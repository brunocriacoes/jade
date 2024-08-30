<?php

namespace App\UseCases;

use App\Model\Webhook;
use App\Library\Asaas;
use App\Model\Store;
use App\Dto\WebhookBlingDto;
use App\Library\Bling;

class CreateWebhookCase
{
    private $params;

    public function __construct($params)
    {
        $this->params = $params;
    }

    public function validateStorePublicId()
    {
        return !empty($this->params['storePublicId']);
    }

    public function removePrefix($storeExternalId)
    {
        $positionHyphen = strpos($storeExternalId, '-');
        if ($positionHyphen !== false) {
            $newStoreExternalId = substr($storeExternalId, $positionHyphen + 1);
            return $newStoreExternalId;
        } else {
            return $storeExternalId;
        }
    }

    public function isAttended($dto)
    {
        return $dto->status == 'Atendido';
    }

    public function isCustomer($dto, $asaas)
    {
        $payload = $asaas->getCustomers($dto->cpfCnpj);
        if ($payload['totalCount'] == 0) {
            $res = $asaas->postCustomers(
                uniqid(),
                $dto->name,
                $dto->email,
                $dto->mobilePhone,
                $dto->cpfCnpj,
                $dto->zipCode,
                $dto->address,
                $dto->addressNumber,
                '',
                $dto->city
            );
            $dto->customerId = $res['id'];
        }else{
            $dto->customerId = $payload['data'][0]['id'];
        }
        
        return $dto;
    }



    public function execute()
    {
        $webhookModel = new Webhook();
        $store = new Store();
        $urlApi = 'https://sandbox.asaas.com/api/v3';
        $storeExternalId = $this->removePrefix($this->params['storePublicId']);
        $tokenApi = $store->getByExternalId($storeExternalId)[0]['asaasApiKey'];
        $blingToken = $store->getByExternalId($storeExternalId)[0]['blingToken'];
        $blingRefreshToken = $store->getByExternalId($storeExternalId)[0]['blingRefreshToken'];
        $publicId = $store->getByExternalId($storeExternalId)[0]['publicId'];
        $blingClientSecret = $store->getByExternalId($storeExternalId)[0]['blingClientSecret'];
        $blingClientId = $store->getByExternalId($storeExternalId)[0]['blingClientId'];
        $asaas = new Asaas($urlApi, $tokenApi);
        $bling = new Bling();
        $dto = new WebhookBlingDto(file_get_contents('php://input'));

        if ($this->isAttended($dto)) {
            $dto = $this->isCustomer($dto, $asaas);
            if($dto->typePayment == 'BOLETO BRADESCO'){
                $resPayment = $asaas->postPayments(
                        $dto->numberOrder,
                        'BOLETO',
                        $dto->customerId,
                        $dto->amount,
                        '',
                        '',
                        '',
                        '',
                        $dto->name,
                        $dto->cpfCnpj,
                        $dto->mobilePhone,
                        $dto->email,
                        $dto->zipCode,
                        $dto->addressNumber,
                        ''
                );
                $linkPdf = $resPayment['bankSlipUrl'];
                $externalId = $resPayment['externalReference'];
                $paymentId = $resPayment['id'];
                $orderNumber = $bling->getOrderByOrder($dto->numberOrder, $blingToken);
                if(isset($orderNumber["error"])){
                    $resRefresh = $bling->refreshToken($blingClientId, $blingClientSecret, $blingRefreshToken);
                    $token = $resRefresh["access_token"];
                    $refreshToken = $resRefresh["refresh_token"];
                    $store->set($publicId, [
                        "blingToken"=> $token,
                        "blingRefreshToken"=> $refreshToken
                    ]);
                    $blingToken = $token;
                    $orderNumber = $bling->getOrderByOrder($dto->numberOrder, $blingToken);
                }
                
                $resOrder = $bling->getOrderById($orderNumber['data'][0]['id'], $blingToken);
                $resUpdate = $bling->updateOrderById(
                    $orderNumber['data'][0]['id'],
                    $paymentId,
                    $linkPdf,
                    $resOrder,
                    $blingToken
                );
        }
        
        return $webhookModel->create([
            'storePublicId' => $this->params['storePublicId'],
            'date' => date('Y-m-d H:i:s'),
            'status' => 'active',
            'payload' => file_get_contents('php://input')
        ]);
    }
}
}