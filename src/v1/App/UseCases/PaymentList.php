<?php

namespace App\UseCases;

use App\Library\Asaas;
use App\Model\Store;

class PaymentList
{
    
    private $params;

    public function __construct($params)
    {
        $this->params = $params;
    }

    public function validateStorePublicId()
    {
        return !empty($this->params['externalId']);
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

    public function getCustomer($cpfCnpj, $asaas)
    {
        return $asaas->getCustomers($cpfCnpj);
    }



    public function execute()
    {
        $store = new Store();
        $urlApi = 'https://api.asaas.com/api/v3';
        
        $storeExternalId = $this->removePrefix($this->params['externalId']);
        $tokenApi = $store->getByExternalId($storeExternalId)[0]['asaasApiKey'];
        $asaas = new Asaas($urlApi, $tokenApi);
        $resCustomer = $this->getCustomer($this->params['cpfCnpj'], $asaas);
        $payload = [];
        if(isset($resCustomer['data'][0]['id'])){
            $customerId = $resCustomer['data'][0]['id'];
            $resPayment = $asaas->getPayments(['customer'=>$customerId, 'limit'=>99]);
            $payload = array_map(function($p){
                return [
                    "vencimento"=>$p['dueDate'],
                    "urlBoleto"=>$p['invoiceUrl'],
                    "valor"=>$p['value']

                ];
            },
            $resPayment['data']
        );
        }

        return $payload;
    }
}