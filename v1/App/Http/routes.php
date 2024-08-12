<?php

use App\help\FactorRouter;

global $router;

$router->post('/login', FactorRouter::add([
    "params" => [
        ["email", "E-mail é obrigatório"],
        ["senha", "Senha é obrigatória"]
    ],
    "message" => ["Erro ao realizar login", "Login realizado com sucesso"],
    "case" => \App\UseCases\LoginCase::class,
    "validations" => [
        ["validateEmail", "E-mail inválido"],
        ["validatePassword", "Senha inválida"]
    ],
    "run" => "execute"
]));

$router->get('/store/list', FactorRouter::add([
    "params" => [
        ["page", "Página é obrigatória"],
        ["itemsPerPage", "Quantidade de itens por página é obrigatória"]
    ],
    "message" => ["Erro ao listar lojas", "Lojas listadas com sucesso"],
    "case" => \App\UseCases\ListStoresCase::class,
    "validations" => [],
    "run" => "execute"
]));

$router->post('/store/register', FactorRouter::add([
    "params" => [
        ["externalId", "External ID é obrigatório"],
        ["name", "Nome é obrigatório"],
        ["email", "E-mail é obrigatório"],
        ["apiKeyAsaas", "API Key Asaas é obrigatória"],
        ["apiKeyBling", "API Key Bling é obrigatória"]
    ],
    "message" => ["Erro ao cadastrar loja", "Loja cadastrada com sucesso"],
    "case" => \App\UseCases\RegisterStoreCase::class,
    "validations" => [
        ["validateName", "Nome inválido"],
        ["validateEmail", "E-mail inválido"]
    ],
    "run" => "execute"
]));

$router->post('/store/update', FactorRouter::add([
    "params" => [
        ["publicId", "Public ID é obrigatório"],
        ["externalId", "External ID é obrigatório"],
        ["name", "Nome é obrigatório"],
        ["email", "E-mail é obrigatório"],
        ["apiKeyAsaas", "API Key Asaas é obrigatória"],
        ["apiKeyBling", "API Key Bling é obrigatória"]
    ],
    "message" => ["Erro ao atualizar loja", "Loja atualizada com sucesso"],
    "case" => \App\UseCases\UpdateStoreCase::class,
    "validations" => [
        ["validatePublicId", "Public ID inválido"],
        ["validateEmail", "E-mail inválido"]
    ],
    "run" => "execute"
]));

$router->post('/store/status', FactorRouter::add([
    "params" => [
        ["publicId", "Public ID é obrigatório"],
        ["status", "Status é obrigatório"]
    ],
    "message" => ["Erro ao alterar status da loja", "Status da loja alterado com sucesso"],
    "case" => \App\UseCases\UpdateStoreStatusCase::class,
    "validations" => [
        ["validatePublicId", "Public ID inválido"]
    ],
    "run" => "execute"
]));

$router->post('/store/delete', FactorRouter::add([
    "params" => [
        ["publicId", "Public ID é obrigatório"]
    ],
    "message" => ["Erro ao deletar loja", "Loja deletada com sucesso"],
    "case" => \App\UseCases\DeleteStoreCase::class,
    "validations" => [
        ["validatePublicId", "Public ID inválido"]
    ],
    "run" => "execute"
]));

$router->get('/user/list', FactorRouter::add([
    "params" => [
        ["page", "Página é obrigatória"],
        ["itemsPerPage", "Quantidade de itens por página é obrigatória"]
    ],
    "message" => ["Erro ao listar usuários", "Usuários listados com sucesso"],
    "case" => \App\UseCases\ListUsersCase::class,
    "validations" => [],
    "run" => "execute"
]));

$router->post('/user/create', FactorRouter::add([
    "params" => [
        ["user", "Nome de usuário é obrigatório"],
        ["email", "E-mail é obrigatório"],
        ["pass", "Senha é obrigatória"],
        ["phone", "Telefone é obrigatório"]
    ],
    "message" => ["Erro ao criar usuário", "Usuário criado com sucesso"],
    "case" => \App\UseCases\CreateUserCase::class,
    "validations" => [
        ["validateEmail", "E-mail inválido"],
        ["validatePassword", "Senha inválida"]
    ],
    "run" => "execute"
]));

$router->post('/user/update', FactorRouter::add([
    "params" => [
        ["publicId", "Public ID é obrigatório"],
        ["user", "Nome de usuário é obrigatório"],
        ["email", "E-mail é obrigatório"],
        ["pass", "Senha é obrigatória"],
        ["phone", "Telefone é obrigatório"],
        ["status", "Status é obrigatório"]
    ],
    "message" => ["Erro ao atualizar usuário", "Usuário atualizado com sucesso"],
    "case" => \App\UseCases\UpdateUserCase::class,
    "validations" => [
        ["validatePublicId", "Public ID inválido"],
        ["validateEmail", "E-mail inválido"]
    ],
    "run" => "execute"
]));

$router->post('/user/delete', FactorRouter::add([
    "params" => [
        ["publicId", "Public ID é obrigatório"]
    ],
    "message" => ["Erro ao deletar usuário", "Usuário deletado com sucesso"],
    "case" => \App\UseCases\DeleteUserCase::class,
    "validations" => [
        ["validatePublicId", "Public ID inválido"]
    ],
    "run" => "execute"
]));

$router->post('/webhook/create/:storePublicId', FactorRouter::add([
    "params" => [
        ["storePublicId", "Store Public ID é obrigatório"]
    ],
    "message" => ["Erro ao criar webhook", "Webhook criado com sucesso"],
    "case" => \App\UseCases\CreateWebhookCase::class,
    "validations" => [
        ["validateStorePublicId", "Store Public ID inválido"]
    ],
    "run" => "execute"
]));

$router->get('/webhook/list', FactorRouter::add([
    "params" => [
        ["page", "Página é obrigatória"],
        ["itemsPerPage", "Quantidade de itens por página é obrigatória"]
    ],
    "message" => ["Erro ao listar webhooks", "Webhooks listados com sucesso"],
    "case" => \App\UseCases\ListWebhooksCase::class,
    "validations" => [],
    "run" => "execute"
]));


