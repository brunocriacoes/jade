<?php

namespace App\UseCases;

use App\Model\Webhook;

class ListWebhooksCase
{
    private $params;

    public function __construct($params)
    {
        $this->params = $params;
    }

    public function execute()
    {
        $webhookModel = new Webhook();
        return $webhookModel->list($this->params['page'], $this->params['itemsPerPage']);
    }
}
