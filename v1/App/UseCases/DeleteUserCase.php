<?php

namespace App\UseCases;

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
        $userModel = new \App\Models\User();
        return $userModel->delete($this->params['publicId']);
    }
}
