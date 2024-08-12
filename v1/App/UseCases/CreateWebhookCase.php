<?php

namespace App\UseCases;

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
        $webhookModel = new \App\Models\Webhook();
        return $webhookModel->create([
            'storePublicId' => $this->params['storePublicId'],
            'date' => date('Y-m-d H:i:s'),
            'status' => 'active',
        ]);
    }
}
