<?php

namespace App\UseCases;

use App\Model\User;

class DeleteUserCase
{
    private $params;

    public function __construct($params)
    {
        $this->params = $params;
    }

    public function validatePublicId()
    {
        return !empty($this->params['publicId']);
    }

    public function execute()
    {
        $userModel = new User();
        $userModel->delete($this->params['publicId']);
        return [];
    }
}
