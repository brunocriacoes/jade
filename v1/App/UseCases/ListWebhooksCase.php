<?php

namespace App\UseCases;

class ListWebhooksCase
{
    private $params;

    public function __construct($params)
    {
        $this->params = $params;
    }

    public function execute()
    {
        $webhookModel = new \App\Models\Webhook();
        return $webhookModel->list($this->params['page'], $this->params['itemsPerPage']);
    }
}
