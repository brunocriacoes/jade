<?php

namespace App\UseCases;

use App\Model\Store;

class ListStoresInfo
{
    private $params;
    private $store;

    public function __construct($params)
    {
        $this->params = $params;
        $this->store = new Store();
    }

    public function isExist()
    {
        $publicId = $this->store->getByPublicId($this->params['publicId']);
        return count($publicId) > 0;
    }

    public function execute()
    {
        return Store::porter($this->store->getByPublicId($this->params['publicId']) [0]);
    }

}
