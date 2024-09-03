<?php
namespace App\Dto;

class WebhookBlingDto{
    public $customerId;
    public $name;
    public $cpfCnpj;
    public $address;
    public $addressNumber;
    public $city;
    public $neighborhood;
    public $zipCode;
    public $state;
    public $email;
    public $mobilePhone;
    public $numberOrder;
    public $totalSale;
    public $status;
    public $paymentPlans;
    public $amount;
    public $dueDate;
    public $typePayment;
    public $id;

    
    public function __construct($data) {
        $data = str_replace("data=","",$data);
        $data = (json_decode($data));
        $client = $data->retorno->pedidos[0]->pedido->cliente;
        $order = $data->retorno->pedidos[0]->pedido;
        $plot = $data->retorno->pedidos[0]->pedido->parcelas;

        $this->customerId = null;
        $this->id = $plot[0]->parcela->idLancamento;
        $this->name = $client->nome ?? null;
        $this->cpfCnpj = $client->cnpj ?? null;
        $this->address = $client->endereco ?? null;
        $this->addressNumber = $client->numero ?? null;
        $this->city = $client->cidade ?? null;
        $this->neighborhood = $client->bairro ?? null;
        $this->zipCode = $client->cep ?? null;
        $this->state = $client->uf ?? null;
        $this->email = $client->email ?? null;
        $this->mobilePhone = $client->celular ?? null;
        $this->totalSale = $order->totalvenda ?? null;
        $this->numberOrder = $order->numero ?? null;
        $this->status = $order->situacao ?? null;
        $this->paymentPlans = count($plot) ?? 1;
        $this->amount = ($order->totalvenda ?? 0) + 3.50;
        $this->dueDate = $plot[0]->parcela->dataVencimento ?? null;
        $this->typePayment = $plot[0]->parcela->forma_pagamento->descricao ?? null;
    }
}
