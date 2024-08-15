<?php

namespace App\UseCases;

use App\Model\Webhook;

class CreateWebhookCase
{
    private $params;

    public function __construct($params)
    {
        $this->params = $params;
    }

    public function validateStorePublicId()
    {
        return !empty($this->params['storePublicId']);
    }

    public function execute()
    {
        $webhookModel = new Webhook();
        return $webhookModel->create([
            'storePublicId' => $this->params['storePublicId'],
            'date' => date('Y-m-d H:i:s'),
            'status' => 'active',
            'payload' => file_get_contents('php://input')
        ]);
    }
}
