<?php

namespace App\UseCases;

use App\Model\User;

class ListUsersInfo
{
    private $params;
    private $user;

    public function __construct($params)
    {
        $this->params = $params;
        $this->user = new User();
    }

    public function isExist()
    {
        $publicId = $this->user->getByPublicId($this->params['publicId']);
        return count($publicId) > 0;
    }

    public function execute()
    {
        return User::porter($this->user->getByPublicId($this->params['publicId']) [0]);
    }
}
