<?php

namespace App\UseCases;

use App\Model\Store;

class ListStoresCase
{
    private $params;

    public function __construct($params)
    {
        $this->params = $params;
    }

    public function execute()
    {
        $storeModel = new Store();
        $list = $storeModel->list($this->params['page'], $this->params['itemsPerPage']);
        return array_map("App\Model\Store::porter", $list);
    }
}
