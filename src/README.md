

## Configuração do Ambiente

Antes de executar o projeto, é necessário configurar as variáveis de ambiente no arquivo `.env`. Este projeto utiliza o SQLite como banco de dados. As variáveis que você precisa definir são:

~~~plaintext
DB_TYPE=sqlite
DB_NAME=dev.sqlite
~~~

## Execute o comando para criar o banco de dados

No terminal, navegue até o diretório onde está localizado o arquivo SQL e execute o seguinte comando:

~~~sql
sqlite3 dev.sqlite < banco.sql
~~~

## Iniciar o servidor local pra testar

~~~
php -S localhost:8001
~~~