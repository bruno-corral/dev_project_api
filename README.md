# Sobre a API

- Utilização de PHP 8 e Laravel 10 para criação e autenticação da API do Blog.
- Utilização de Seed para geração de Categorias.
- Utilização do EloquentORM e Query Builder para fazer querys que irão trazer os dados do banco de dados.
- Utilização do Banco de dados MySQL. O banco de dados possui tabelas de usuários, categorias e posts.
- Utilizado migrations para a criação das tabelas.
- Para validação de dados recebidos pela API foi usado Requests.

________________________

## Como executar a api

1. Execute no terminal na raiz do projeto o comando `php artisan migrate` para criar o banco de dados `dev_project_api` e também as tabelas no banco de dados;

2. Execute no terminal na raiz do projeto o comando `php artisan db:seed` para criar registros na tabela de Categorias;

3. Execute no terminal na raiz do projeto o comando `php atisan serve` para iniciar o servidor do Laravel;

4. Para acessar use a url: `http://127.0.0.1:8000`