<?php

namespace App\UseCases;

class ListUsersCase
{
    private $params;

    public function __construct($params)
    {
        $this->params = $params;
    }

    public function execute()
    {
        $userModel = new \App\Models\User();
        return $userModel->list($this->params['page'], $this->params['itemsPerPage']);
    }
}
