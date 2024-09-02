<?php

namespace App\Library;

class Asaas
{

	protected $urlAPI;
	protected $tokenAPI;

	public function __construct($urlAPI, $tokenAPI)
	{
		$this->urlAPI = $urlAPI;
		$this->tokenAPI = $tokenAPI;
	}

	public function get($url, $params = array())
	{
		return $this->request('GET', $url, $params);
	}

	public function post($url, $data = array())
	{
		return $this->request('POST', $url, $data);
	}

	public function put($url, $data = array())
	{
		return $this->request('PUT', $url, $data);
	}

	public function delete($url, $data = array())
	{
		return $this->request('DELETE', $url, $data);
	}

	protected function request($method, $url, $data = array())
	{
		$method = strtoupper($method);

		$ch = curl_init();
		$url = $this->urlAPI . $url;

		$options = array(
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_AUTOREFERER    => true,
			CURLOPT_CONNECTTIMEOUT => 120,
			CURLOPT_TIMEOUT        => 120,
			CURLOPT_MAXREDIRS      => 10,
			CURLOPT_HEADER         => false,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HTTPHEADER     => array(
				'Content-Type: application/json',
				'access_token: ' . $this->tokenAPI,
				'Accept: */*',
			),
		);

		switch ($method) {
			case 'GET':
				$url .= '?' . http_build_query($data);
				break;
			case 'POST':
				$options[CURLOPT_POST] = true;
				$options[CURLOPT_POSTFIELDS] = json_encode($data, JSON_UNESCAPED_UNICODE);
				break;
			case 'PUT':
			case 'DELETE':
				$options[CURLOPT_CUSTOMREQUEST] = $method;
				$options[CURLOPT_POSTFIELDS] = http_build_query($data);
				break;
		}

		$options[CURLOPT_URL] = $url;
		curl_setopt_array($ch, $options);
		$result = curl_exec($ch);
		curl_close($ch);

		return json_decode($result, true);
	}

	protected function clearNumber(string $number): string
	{
		return preg_replace('/\D/', '', $number);
	}

	public function postCustomers(
		string $external_fk,
		string $name,
		string $email,
		string $phone_numbers,
		string $cpf,
		string $postalCode,
		string $address,
		string $addressNumber,
		string $complement,
		string $province
	) {
		$payload = [
			'name' => $name,
			'email' => $email,
			"phone" => $this->clearNumber($phone_numbers),
			"mobilePhone" => $this->clearNumber($phone_numbers),
			"cpfCnpj" => $this->clearNumber($cpf),
			"postalCode" => $this->clearNumber($postalCode),
			"address" => $address,
			"addressNumber" => $addressNumber,
			"complement" => $complement,
			"province" => $province,
			"externalReference" => $external_fk,
			"notificationDisabled" => true,
			"additionalEmails" => "",
			"municipalInscription" => "",
			"stateInscription" => "",
			"observations" => ""
		];
		return $this->post('/customers', $payload, false);
	}

	function getCustomers(string $cpfCnpj)
	{
		return $this->get("/customers", [
			"cpfCnpj" => $this->clearNumber($cpfCnpj)
		]);
	}

	public function getSubscriptions($customerID)
	{
		return $this->get("/subscriptions", [
			"customer" => $customerID,
			"limit" => '100',
			"includeDeleted" => 'true',
		]);
	}

	public function getSubscriptionsByID($ID)
	{
		return $this->get("/subscriptions/{$ID}", []);
	}

	public function postCustomersByID(
		$customer_id,
		$name,
		$email,
		$mobilePhone,
		$cpfCnpj,
		$postalCode,
		$address,
		$addressNumber,
		$complement,
		$cidade,
		$external_fk
	) {
		return $this->post("/customers/{$customer_id}", [
			"name" => $name,
			"email" => $email,
			"mobilePhone" => $mobilePhone,
			"cpfCnpj" => $cpfCnpj,
			"postalCode" => $postalCode,
			"address" => $address,
			"addressNumber" => $addressNumber,
			"complement" => $complement,
			"province" => $cidade,
			"externalReference" => $external_fk,
		]);
	}

	public function delSubscriptionsByID($sub_id)
	{
		return $this->delete("/subscriptions/{$sub_id}", []);
	}

	public function postSubscriptionsByID(
		$sub_id,
		$endDate = null,
		$status = 'INACTIVE',
		$cycle = "MONTHLY",
		$updatePendingPayments = false,
		$billingType = null,
		$value = null,
		$nextDueDate = null
	) {
		$payload = array_filter([
			"endDate" => $endDate,
			"status" => $status,
			"cycle" => $cycle,
			"updatePendingPayments" => $updatePendingPayments,
			"billingType" => $billingType,
			"value" => $value,
			"nextDueDate" => $nextDueDate,
		], function ($value) {
			return $value !== null;
		});
		return $this->post("/subscriptions/{$sub_id}", array_values($payload));
	}

	public function postPaymentsByInvoiceID(
		$invoiceID,
		$billingType,
		$value,
		$dueDate,
		$customer
	) {
		return $this->post("/payments/{$invoiceID}", [
			"billingType" => $billingType,
			"value" => $value,
			"dueDate" => $dueDate,
			"customer" => $customer,
		]);
	}

	public function postPaymentsByInvoiceIDpayWithCreditCard(
		$token_card,
		$payment_id
	) {
		return $this->post("/payments/{$payment_id}/payWithCreditCard", [
			"creditCardToken" => $token_card,
		]);
	}

	public function getFinanceBalance()
	{
		return $this->get("/finance/balance", []);
	}

	public function getFinancePaymentStatistics()
	{
		return $this->get("/finance/payment/statistics", [
			"customer" => null,
			"billingType" => "CREDIT_CARD",
			"status" => "CONFIRMED",
			"anticipated" => null,
			"dateCreated[ge]" => null,
			"dateCreated[le]" => null,
			"dueDate[ge]" => null,
			"dueDate[le]" => null,
			"estimatedCreditDate[ge]" => null,
			"estimatedCreditDate[le]" => null,
			"externalReference" => null,
		]);
	}

	public function getTransfers()
	{
		return $this->get("/transfers", [
			"limit" => 100
		]);
	}

	public function postPixAddressKeys()
	{
		return $this->post("/pix/addressKeys", [
			"type" => "EVP"
		]);
	}

	public function postWebhook($url, $email)
	{
		return $this->post("/webhook", [
			"url" => $url,
			"email" => $email,
			"enabled" => true,
			"interrupted" => false,
			"apiVersion" => 3,
			"authToken" => null
		]);
	}

	public function postAccounts(
		string $name,
		string $email,
		string $cpfCnpj,
		string $companyType,
		string $phone,
		string $mobilePhone,
		string $address,
		string $addressNumber,
		string $complement,
		string $province,
		string $postalCode,
		string $account,
		string $accountDigit,
		string $accountName,
		string $agency,
		string $bank,
		string $bankAccountType,
		string $incomeValue
	) {
		$payload = [
			"name" => $name,
			"email" => $email,
			"cpfCnpj" => $this->clearNumber($cpfCnpj),
			"companyType" => $companyType,
			"phone" => $this->clearNumber($phone),
			"mobilePhone" => $this->clearNumber($mobilePhone),
			"address" => $address,
			"addressNumber" => $addressNumber,
			"complement" => $complement,
			"province" => $province,
			"postalCode" => $postalCode,
			"incomeValue" => $postalCode,
			"bankAccount" => [
				"account" => $this->clearNumber($account),
				"accountDigit" => $this->clearNumber($accountDigit),
				"accountName" => $accountName,
				"agency" => $this->clearNumber($agency),
				"bank" => $this->clearNumber($bank),
				"bankAccountType" => $bankAccountType,
				"cpfCnpj" => $this->clearNumber($cpfCnpj),
				"name" => $name,
			]
		];
		if ($bankAccountType == "MEI") {
			$payload["bankAccount"]["thirdPartyAccount"] = true;
		}
		return $this->post('/accounts', $payload);
	}

	function postAccountsWhateLabel(
		string $name,
		string $email,
		string $cpfCnpj,
		string $birthDate,
		string $mobilePhone,
		string $incomeValue,
		string $address,
		string $addressNumber,
		string $province,
		string $postalCode,
		string $url,
		string $companyType = "MEI"
	) {
		$payload = [
			"webhooks" => [
				[
					"apiVersion" => 3,
					"enabled" => true,
					"interrupted" => true,
					"name" => "v1",
					"url" => $url,
					"email" => $name
				]
			],
			"name" => $name,
			"email" => $email,
			"cpfCnpj" => $this->clearNumber($cpfCnpj),
			"birthDate" => $birthDate,
			"mobilePhone" => $this->clearNumber($mobilePhone),
			"incomeValue" => $this->clearNumber($incomeValue),
			"address" => $address,
			"addressNumber" => $addressNumber,
			"province" => $province,
			"postalCode" => $this->clearNumber($postalCode),
		];
		$cpfCnpj = $this->clearNumber("cpfCnpj");
		if (strlen($cpfCnpj) > 11) {
			$payload["companyType"] = $companyType;
		}
		return $this->post('/accounts', $payload);
	}

	public function postBankAccounts(
		string $bankCode,
		string $agency,
		string $account,
		string $accountDigit,
		string $bankAccountType,
		string $name,
		string $cpfCnpj,
		string $responsiblePhone,
		string $responsibleEmail
	) {
		return $this->post('/bankAccounts', [
			"accountName" => "Conta Bancária",
			"thirdPartyAccount" => true,
			"bankCode" => $this->clearNumber($bankCode),
			"agency" => $this->clearNumber($agency),
			"account" => $this->clearNumber($account),
			"accountDigit" => $this->clearNumber($accountDigit),
			"bankAccountType" => $bankAccountType,
			"name" => $name,
			"cpfCnpj" => $this->clearNumber($cpfCnpj),
			"responsiblePhone" => $this->clearNumber($responsiblePhone),
			"responsibleEmail" => $responsibleEmail,
			"mainAccount" => true
		]);
	}

	public function getBankAccounts(
		$cpfCnpj = null,
		$agency = null,
		$bankCode = null
	) {
		$payload = [
			"cpfCnpj" => $this->clearNumber($cpfCnpj),
			"agency" => $this->clearNumber($agency),
			"bankCode" => $this->clearNumber($bankCode),
		];
		$payload = array_filter($payload, function ($value) {
			return $value !== null;
		});
		return $this->get("/bankAccounts", array_values($payload));
	}

	public function getMyAccountDocuments(
		$cpfCnpj,
		$agency,
		$bankCode
	) {
		return $this->get("/myAccount/documents", [
			"cpfCnpj" => $cpfCnpj,
			"agency" => $agency,
			"bankCode" => $bankCode,
		]);
	}

	public function postMyAccountDocumentsByID(
		$ID
	) {
		return $this->post("/myAccount/documents/{$ID}", []);
	}

	public function postBankAccountsMainAccount(
		$accountName,
		$thirdPartyAccount,
		$bank,
		$agency,
		$account,
		$accountDigit,
		$bankAccountType,
		$name,
		$cpfCnpj,
		$responsiblePhone,
		$responsibleEmail
	) {
		return $this->post("/bankAccounts/mainAccount", [
			"accountName" => $accountName,
			"thirdPartyAccount" => $thirdPartyAccount,
			"bank" => $bank,
			"agency" => $agency,
			"account" => $account,
			"accountDigit" => $accountDigit,
			"bankAccountType" => $bankAccountType,
			"name" => $name,
			"cpfCnpj" => $cpfCnpj,
			"responsiblePhone" => $responsiblePhone,
			"responsibleEmail" => $responsibleEmail,
		]);
	}

	public function postTransfers(
		$bankAccountInfoId,
		$value
	) {
		return $this->post("/transfers", [
			"value" => $value,
			"bankAccountInfoId" => $bankAccountInfoId
		]);
	}

	public function validPaymentType($type)
	{
		return in_array($type, ["BOLETO", "CREDIT_CARD", "PIX"]);
	}

	public function getPaymentsInvoice_IDidentificationField($invoice_ID)
	{
		return $this->get("/payments/{$invoice_ID}/identificationField",  [
			"id" => $invoice_ID
		]);
	}

	public function getPaymentsInvoice_IDpixQrCode($invoice_ID)
	{
		return $this->get("/payments/{$invoice_ID}/pixQrCode", []);
	}

	public function getSubscriptionsIDpayments($ID)
	{
		return $this->get("/subscriptions/{$ID}/payments", []);
	}

	public function getPaymentsID($id)
	{
		return $this->get("/payments/{$id}", []);
	}

	public function postPayments(
		string $external_fk,
		string $tipo_pagamento,
		string $customer,
		string $valor,
		string $card_nome,
		string $card_numero,
		string $card_validade,
		string $card_cvv,
		string $nome,
		string $cpf,
		string $telefone,
		string $email,
		string $cep,
		string $numero,
		string $complemento,
		$installmentCount = 1,
		array $split = []
	) {
		$payload = [
			"customer" => $customer,
			"billingType" => $tipo_pagamento,
			"value" => $valor,
			"dueDate" => date('Y-m-d', strtotime('+7 days')),
			"description" => "Doação Unica",
			"externalReference" => $external_fk,
			"postalService" => false,
		];
		if ($tipo_pagamento == "BOLETO") {
			$payload["discount"] = [
				"value" => 0,
				"dueDateLimitDays" => 0
			];
			$payload["interest"] = ["value" => 0];
		}
		if ($tipo_pagamento == "CREDIT_CARD") {
			$payload["creditCard"] = [
				"holderName" => $card_nome,
				"number" => $card_numero,
				"expiryMonth" => substr($this->clearNumber($card_validade), 0, 2),
				"expiryYear" => substr($this->clearNumber($card_validade), 2, 4),
				"ccv" => $this->clearNumber($card_cvv)
			];
			$payload["creditCardHolderInfo"] = [
				"name" => $nome,
				"email" => $email,
				"cpfCnpj" => $cpf,
				"postalCode" => $cep,
				"addressNumber" => $numero,
				"addressComplement" => $complemento,
				"phone" => $this->clearNumber($telefone),
				"mobilePhone" => $this->clearNumber($telefone)
			];
			$payload["dueDate"] = date('Y-m-d');
			$payload["remoteIp"] = $_SERVER['REMOTE_ADDR'];
		}
		if (!empty($split)) {
			$payload['split'] = $split;
		}
		if ($installmentCount > 1) {
			$payload['installmentCount'] = $installmentCount;
			$payload['installmentValue'] = ($valor / $installmentCount);
		}
		return $this->post('/payments', $payload);
	}

	public function postSubscriptions(
		string $external_fk,
		string $tipo_pagamento,
		string $customer,
		string $valor,
		string $card_nome,
		string $card_numero,
		string $card_validade,
		string $card_cvv,
		string $nome,
		string $cpf,
		string $telefone,
		string $email,
		string $cep,
		string $numero,
		string $complemento,
		array $split = []
	) {
		$payload = [
			"customer" => $customer,
			"billingType" => $tipo_pagamento,
			"value" => $valor,
			"description" => "Assinatura",
			"externalReference" => $external_fk,
			"postalService" => false,
			"nextDueDate" => date('Y-m-d', strtotime('+7 days')),
			"cycle" => "MONTHLY",
		];
		if ($tipo_pagamento == "BOLETO") {
			$payload["discount"] = [
				"value" => 0,
				"dueDateLimitDays" => 0
			];
			$payload["interest"] = ["value" => 0];
		}
		if ($tipo_pagamento == "CREDIT_CARD") {
			$payload["creditCard"] = [
				"holderName" => $card_nome,
				"number" => $card_numero,
				"expiryMonth" => substr($this->clearNumber($card_validade), 0, 2),
				"expiryYear" => substr($this->clearNumber($card_validade), 2, 4),
				"ccv" => $this->clearNumber($card_cvv)
			];
			$payload["creditCardHolderInfo"] = [
				"name" => $nome,
				"email" => $email,
				"cpfCnpj" => $cpf,
				"postalCode" => $cep,
				"addressNumber" => $numero,
				"addressComplement" => $complemento,
				"phone" => $this->clearNumber($telefone),
				"mobilePhone" => $this->clearNumber($telefone)
			];
			$payload["remoteIp"] = $_SERVER['REMOTE_ADDR'];
			$payload["maxPayments"] = 24;
			$payload["nextDueDate"] = date('Y-m-d');
		}
		if (!empty($split)) {
			$payload['split'] = $split;
		}
		return $this->post('/subscriptions', $payload);
	}

	function postBillIdCancel($id)
	{
		$payload = [];
		return $this->post("/bill/{$id}/cancel", $payload);
	}

	function gettBillId($id)
	{
		$payload = [];
		return $this->get("/bill/{$id}", $payload);
	}

	function gettBill($offset = 1, $limit = 100)
	{
		$payload = [];
		return $this->get("/bill?offset={$offset}&limit={$limit}", $payload);
	}

	function postBill(
		string $identificationField,
		string $dueDate,
		float $value,
		string $description
	) {
		$payload = [
			"identificationField" => $identificationField,
			"dueDate" => $dueDate,
			"value" => $value,
			"description" => $description,
		];
		return $this->post("/bill", $payload);
	}

	function getFinancialTransactions(
		string $startDate,
		string $finishDate,
		float $offset
	) {
		$payload = [];
		return $this->post("/financialTransactions?startDate={$startDate}&finishDate={$finishDate}&offset={$offset}&limit=10", $payload);
	}

	static function getWebHook()
	{
		$getJson = file_get_contents('php://input');
		$getJson = (array) json_decode($getJson, true);
		$request = $_REQUEST;
		$payload = array_merge($getJson, $request);
		return [
			'subscription'   => $payload['payment']['subscription'] ?? "",
			'external_id'    => $payload['payment']['externalReference'] ?? "",
			'dueDate'        => $payload['payment']['dueDate'] ?? "",
			'dueDateInvoice' => $payload['payment']['dueDate'] ?? "",
			'status'         => $payload['payment']['status'] ?? "",
			'tipo'           => $payload['payment']['billingType'] ?? "",
			'url'            => $payload['payment']['bankSlipUrl'] ?? "",
			'ID'             => $payload['payment']['id'] ?? "",
			'value'          => $payload['payment']['value'] ?? "",
			'event'          => $payload['event'] ?? "",
		];
	}
}
