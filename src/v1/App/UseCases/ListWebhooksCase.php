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
        return array_map(function($e){
            $e['payload'] = str_replace('data=', '', $e['payload']);
            return $e;
        },$webhookModel->list($this->params['page'], 12));
    }
}
