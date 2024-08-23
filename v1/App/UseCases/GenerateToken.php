<?php

namespace App\UseCases;

use App\Model\Store;

class GenerateToken
{
    private $data;
    private $store;

    public function __construct($data)
    {
        $this->data = $data;
        $this->store = new Store();
    }

    public function isExist(){
        $externalId = $this->store->getByExternalId($this->data['externalId']);
        return count($externalId) > 0;
    }

    public function execute(){
        return $this->data;
    }
}