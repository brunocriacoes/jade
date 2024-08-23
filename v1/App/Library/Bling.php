<?php

namespace App\Library;

class BlingAPI
{

    private $baseUrl;

    public function __construct()
    {
        $this->baseUrl = 'https://bling.com.br/Api';
    }

    private function request($path, $method = 'GET', $data = null, $authBasic = null)
    {
        $url = $this->baseUrl . $path;

        if ($method === 'GET' && !empty($data)) {
            $queryString = http_build_query($data);
            $url .= '?' . $queryString;
        }

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $headers = [];

        if ($authBasic) {
            $headers[] = 'Authorization: Basic ' . base64_encode($authBasic);
        }

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            $headers[] = 'Content-Type: application/x-www-form-urlencoded';
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

    function generateBasic($client_id, $client_secret)
    {
        return base64_encode("{$client_id}:{$client_secret}");
    }

    function generateToken($client_id, $client_secret, $code)
    {

        return $this->request(
            "/v3/oauth/token",
            "GET",
            [
                "grant_type" => "authorization_code",
                "code" => $code
            ],
            $this->generateBasic($client_id, $client_secret)
        );
    }

    function refreshToken($client_id, $client_secret, $refreshToken)
    {

        return $this->request(
            "/v3/oauth/token",
            "GET",
            [
                "grant_type" => "refresh_token",
                "refresh_token" => $refreshToken
            ],
            $this->generateBasic($client_id, $client_secret)
        );
    }
}
