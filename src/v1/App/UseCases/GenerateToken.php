<?php

namespace App\UseCases;

use App\Library\Bling;
use App\Model\Store;

class GenerateToken
{
    private $code;
    private $externalId;
    private $store;

    public function __construct($data)
    {
        $this->code = $data['code'];
        $this->externalId = $data['externalId'];
        $this->store = new Store();
    }

    public function isExist(){
        $id = str_replace('bling-','', $this->externalId);
        $externalId = $this->store->getByExternalId($id);
        return count($externalId) > 0;
    }

    public function execute(){
        $id = str_replace('bling-','', $this->externalId);
        $store = $this->store->getByExternalId($id)[0];
        $bling = new Bling();
        $resBling = $bling->generateToken($store['blingClientId'],$store['blingClientSecret'],$this->code);
        if(!isset($resBling['error'])){
            $this->store->set($store['publicId'], [
                "blingToken"=>$resBling['access_token'],
                "blingRefreshToken"=>$resBling['refresh_token'],
            ]);
        }

        return $resBling;
    }
}