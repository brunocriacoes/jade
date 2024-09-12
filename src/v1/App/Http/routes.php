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

$router->get('/v1/store/info', FactorRouter::add([
    "params" => [
        ["publicId", "Identificado obrigatório"]
    ],
    "message" => ["Erro ao listar lojas", "Lojas listada com sucesso"],
    "case" => \App\UseCases\ListStoresInfo::class,
    "validations" => [
        ["isExist", "Loja não encontrada"]
    ],
    "run" => "execute"
]));

$router->post('/v1/store/register', FactorRouter::add([
    "params" => [
        ["externalId", "External ID é obrigatório"],
        ["name", "Nome é obrigatório"],
        ["email", "E-mail é obrigatório"],
        ["asaasApiKey", "API Key Asaas é obrigatória"],
        ["blingClientId", "Client ID Bling é obrigatório"],
        ["blingClientSecret", "Client Secret Bling é obrigatório"]
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
        ["blingClientId", "Client ID Bling é obrigatório"],
        ["blingClientSecret", "Client Secret Bling é obrigatório"],
        ["asaasApiKey", "Informe Api key do Asaas"]
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

$router->get('/v1/user/info', FactorRouter::add([
    "params" => [
        ["publicId", "Identificador é obrigatória"]
    ],
    "message" => ["Erro ao listar usuários", "Usuários listados com sucesso"],
    "case" => \App\UseCases\ListUsersInfo::class,
    "validations" => [
       [ "isExist", "Usuário não encontrado"]
    ],
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
        ["userExist", "Este e-mail já está sendo utilizado"]
    ],
    "run" => "execute"
]));

$router->post('/v1/user/update', FactorRouter::add([
    "params" => [
        ["publicId", "Public ID é obrigatório"],
        ["name", "Nome de usuário é obrigatório"],
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

$router->get('/v1/payment/list/{externalId}', FactorRouter::add([
    "params" => [
        ["externalId", "External ID é obrigatório"],
        ["cpfCnpj", "CPF ou CNPJ é obrigatório"]

    ],
    "message" => ["Erro ao listar informações", "Listado com sucesso"],
    "case" => \App\UseCases\PaymentList::class,
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

$router->post('/v1/recover/pass', FactorRouter::add([
    "params" => [
        ["email", "Email é obrigatória"],
    ],
    "message" => ["Erro ao recuperar senha", "link enviado com sucesso"],
    "case" => \App\UseCases\RecoverPass::class,
    "validations" => [],
    "run" => "execute"
]));

$router->post('/v1/alter/pass', FactorRouter::add([
    "params" => [
        ["email", "Email é obrigatória"],
        ["code", "Informe o codigo"],
        ["pass", "Informe a senha"],
    ],
    "message" => ["Erro ao alterar a senha", "Senha alterada com sucesso"],
    "case" => \App\UseCases\AlterPass::class,
    "validations" => [
        ["isEmail", "Email não cadastrado"],
        ["isCode", "Codigo invalido"],
        ["passValid", "Sua senha deve ter pelo menos 8 caracteres, incluir uma letra maiúscula, uma letra minúscula, um número, e um caractere especial."],
    ],
    "run" => "execute"
]));

$router->post('/v1/generate/token', FactorRouter::add([
    "params" => [
        ["externalId", "informe o identificador da loja"],
        ["code", "informe um código"],

    ],
    "message" => ["Erro ao gerar token", "Token gerado com sucesso"],
    "case" => \App\UseCases\GenerateToken::class,
    "validations" => [
        ["isExist", "Identificador não encontrado"],
    ],
    "run" => "execute"
    ]));

$router->post('/v1/subscribe/bling', FactorRouter::add([
    "params" => [
        ["externalId", "informe o identificador da loja"]

    ],
    "message" => ["Erro no escrever-se", "Inscrito com sucesso"],
    "case" => \App\UseCases\SubscribeBling::class,
    "validations" => [
        ["isExist", "Identificador não encontrado"],
    ],
    "run" => "execute"
    ]));