<?php

namespace App\UseCases;

use App\Model\Webhook;
use App\Library\Asaas;
use App\Model\Store;
use App\Dto\WebhookBlingDto;

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
        $asaas = new Asaas($urlApi, $tokenApi);
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
                var_dump($resPayment);
        };
        return [];
        return $webhookModel->create([
            'storePublicId' => $this->params['storePublicId'],
            'date' => date('Y-m-d H:i:s'),
            'status' => 'active',
            'payload' => file_get_contents('php://input')
        ]);
    }
}
}