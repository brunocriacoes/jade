<?php

global $router;

use App\help\FactorRouter;

$router->post('/v1/login', FactorRouter::add([
    "params" => [
        ["email", "E-mail é obrigatório"],
        ["pass", "Senha é obrigatória"]
    ],
    "message" => ["Erro ao realizar login", "Login realizado com sucesso"],
    "case" => \App\UseCases\LoginCase::class,
    "validations" => [
        ["emailValid", "E-mail inválido"],
        ["userValid", "Usuário ou senha inválido"]
    ],
    "run" => "execute"
]));

$router->get('/v1/store/list', FactorRouter::add([
    "params" => [
        ["page", "Página é obrigatória"],
        ["itemsPerPage", "Quantidade de itens por página é obrigatória"]
    ],
    "message" => ["Erro ao listar lojas", "Lojas listadas com sucesso"],
    "case" => \App\UseCases\ListStoresCase::class,
    "validations" => [],
    "run" => "execute"
]));

$router->post('/v1/store/register', FactorRouter::add([
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

$router->post('/v1/store/update', FactorRouter::add([
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

$router->post('/v1/store/status', FactorRouter::add([
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

$router->post('/v1/store/delete', FactorRouter::add([
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

$router->get('/v1/user/list', FactorRouter::add([
    "params" => [
        ["page", "Página é obrigatória"],
        ["itemsPerPage", "Quantidade de itens por página é obrigatória"]
    ],
    "message" => ["Erro ao listar usuários", "Usuários listados com sucesso"],
    "case" => \App\UseCases\ListUsersCase::class,
    "validations" => [],
    "run" => "execute"
]));

$router->post('/v1/user/create', FactorRouter::add([
    "params" => [
        ["name", "Nome de usuário é obrigatório"],
        ["email", "E-mail é obrigatório"],
        ["pass", "Senha é obrigatória"],
        ["phone", "Telefone é obrigatório"]
    ],
    "message" => ["Erro ao criar usuário", "Usuário criado com sucesso"],
    "case" => \App\UseCases\CreateUserCase::class,
    "validations" => [
        ["validateEmail", "E-mail inválido"],
        ["validatePassword", "Sua senha deve ter pelo menos 8 caracteres, incluir uma letra maiúscula, uma letra minúscula, um número, e um caractere especial."],
        ["userExist", "Este e-mail já está sendo ultilizado"]
    ],
    "run" => "execute"
]));

$router->post('/v1/user/update', FactorRouter::add([
    "params" => [
        ["publicId", "Public ID é obrigatório"],
        ["name", "Nome de usuário é obrigatório"],
        ["email", "E-mail é obrigatório"],
        ["phone", "Telefone é obrigatório"],
        ["status", "Status é obrigatório"]
    ],
    "message" => ["Erro ao atualizar usuário", "Usuário atualizado com sucesso"],
    "case" => \App\UseCases\UpdateUserCase::class,
    "validations" => [
        ["validatePublicId", "Public ID inválido"]
    ],
    "run" => "execute"
]));

$router->post('/v1/user/update/pass', FactorRouter::add([
    "params" => [
        ["publicId", "Public ID é obrigatório"],
        ["pass", "Senha é obrigatório"],
    ],
    "message" => ["Erro ao atualizar senha", "Senha atualizada com sucesso"],
    "case" => \App\UseCases\UpdateUserCase::class,
    "validations" => [
        ["validatePublicId", "Public ID inválido"]
    ],
    "run" => "execute"
]));

$router->post('/v1/user/delete', FactorRouter::add([
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

$router->post('/v1/webhook/create/{storePublicId}', FactorRouter::add([
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

$router->get('/v1/webhook/list', FactorRouter::add([
    "params" => [
        ["page", "Página é obrigatória"],
        ["itemsPerPage", "Quantidade de itens por página é obrigatória"]
    ],
    "message" => ["Erro ao listar webhooks", "Webhooks listados com sucesso"],
    "case" => \App\UseCases\ListWebhooksCase::class,
    "validations" => [],
    "run" => "execute"
]));

$router->get('/v1/recover/pass', FactorRouter::add([
    "params" => [
        ["email", "Email é obrigatória"],
    ],
    "message" => ["Erro ao recuperar senha", "link enviado com sucesso"],
    "case" => \App\UseCases\RecoverPass::class,
    "validations" => [],
    "run" => "execute"
]));