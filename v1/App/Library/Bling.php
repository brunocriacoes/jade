<?php

namespace App\Library;

class BlingAPI
{

    private $apiKey;
    private $baseUrl;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
        $this->baseUrl = 'https://bling.com.br/Api/v2/';
    }

    private function request($endpoint, $method = 'GET', $data = null)
    {
        $url = $this->baseUrl . $endpoint . '/json/?apikey=' . $this->apiKey;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            if ($data) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            }
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode >= 200 && $httpCode < 300) {
            return json_decode($response, true);
        } else {
            throw new \Exception("Error: HTTP Code $httpCode - $response");
        }
    }

    public function cadastrarWebhook($evento, $url)
    {
        $data = [
            'webhook' => [
                'evento' => $evento,
                'url' => $url
            ]
        ];
        return $this->request('webhook', 'POST', $data);
    }

    public function listarWebhooks()
    {
        return $this->request('webhook');
    }

    public function atualizarStatusPedido($idPedido, $status)
    {
        $data = [
            'pedido' => [
                'id' => $idPedido,
                'situacao' => $status
            ]
        ];
        return $this->request('pedido', 'POST', $data);
    }

    public function adicionarPdfBoletoPedido($idPedido, $pdfUrl)
    {
        $data = [
            'pedido' => [
                'id' => $idPedido,
                'boleto' => [
                    'pdf' => $pdfUrl
                ]
            ]
        ];
        return $this->request('pedido', 'POST', $data);
    }

    public function listarPedidos()
    {
        return $this->request('pedidos');
    }

    public function obterEventosWebhook()
    {
        return [
            'pedido_status_alterado',
            'nota_fiscal_emitida',
            'estoque_atualizado',
            'cliente_cadastrado',
            'produto_cadastrado',
            'cobranca_criada'
        ];
    }

    public function obterStatusPedido()
    {
        return [
            'aberto',
            'fechado',
            'cancelado',
            'entregue',
            'pendente',
            'em_transito',
            'devolvido',
            'em_espera',
            'finalizado',
        ];
    }
}
