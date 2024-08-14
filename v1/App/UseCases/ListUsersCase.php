<?php

namespace App\UseCases;

use App\Model\User;

class ListUsersCase
{
    private $params;
    private $user;

    public function __construct($params)
    {
        $this->params = $params;
        $this->user = new User();
    }

    public function execute()
    {

        return array_map("App\Model\User::porter", $this->user->list($this->params['page'], $this->params['itemsPerPage']));
    }
}
