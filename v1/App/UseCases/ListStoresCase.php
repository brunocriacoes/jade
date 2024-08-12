<?php

namespace App\UseCases;

class ListStoresCase
{
    private $params;

    public function __construct($params)
    {
        $this->params = $params;
    }

    public function execute()
    {
        $storeModel = new \App\Models\Store();
        return $storeModel->list($this->params['page'], $this->params['itemsPerPage']);
    }
}
