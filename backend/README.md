## Back-end Setup (Laravel)

## Instalar as dependências

    composer install

## Copiar o arquivo de ambiente

cp .env.example .env

## Configurar o banco de dados no .env

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=todo_db
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha

## Gerar a chave da aplicação

php artisan key:generate

## Executar as migrações

php artisan migrate

## Rodar o servidor Laravel

php artisan serve 
