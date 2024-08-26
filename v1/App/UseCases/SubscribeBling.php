<?php

namespace App\UseCases;

use App\Library\Bling;
use App\Model\Store;

class SubscribeBling
{
    private $externalId;
    private $store;

    public function __construct($data)
    {
        $this->externalId = $data['externalId'];
        $this->store = new Store();
    }

    public function isExist(){
        $externalId = $this->store->getByExternalId($this->externalId);
        return count($externalId) > 0;
    }

    public function execute(){
        $store = $this->store->getByExternalId($this->externalId)[0];
        $bling = new Bling();
        $auth = $bling->generateBasic($store['blingClientId'], $store['blingClientSecret']);
        $token = $store['blingToken'];
        $cadastrarWebhook = $bling->cadastrarWebhook(
            'Vendas',
            'https://api.paramour.com.br/v1/webhook/create/bling-'.$this->externalId,
            ["vendas.create"],
            $token
        );
        // if(!isset($resBling['error'])){
        //     $this->store->set($store['publicId'], [
        //         "blingToken"=>$resBling['access_token'],
        //         "blingRefreshToken"=>$resBling['refresh_token'],
        //     ]);
        // }
        return $cadastrarWebhook;
    }
}