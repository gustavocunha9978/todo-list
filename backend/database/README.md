

# 📋 Todo List (Database)

Este projeto é um sistema de lista de tarefas (**To-do List**) desenvolvido com **Laravel** e **SQLite**.

# Instale as dependências

composer install

# Copie o arquivo .env

cp .env.example .env

# Gere a chave da aplicação

php artisan key:generate

# Crie o arquivo do banco de dados SQLite

touch database/database.sqlite

# Execute as migrations

 php artisan migrate

# Suba o servidor

    php artisan serve

# Agora, o sistema estará disponível em http://localhost:8000.
