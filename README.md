CRUD com Laravel 12 (cadastrar, listar, editar e apagar)

## Requisitos

* PHP8.2 ou superior (conferir versão: php -v)
* Composer (conferir versão: composer --version)
* Node.js 22 ou superior (conferir versão: node -v)
* Git (conferir versão: git -v)

## Sequência para criar o projeto (ao criar pela primeira vez)

Criar o projeto com Laravel

```
composer create-project laravel/laravel
```

Iniciar o projeto criado com Laravel
```
php artisan serve
```

Acessar o conteúdo padrão do Laravel
```
http://127.0.0.1:8000
```

## Rodar o projeto (retomar projeto já existente)

- Baixar os arquivos do GitHub
```
git clone <repositorio_url>
```

- Duplicar o arquivo ".env.example" e renomear para ".env".
- Alterar no arquivo .env, as credenciais do banco de dados.

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nome_do_banco_de_dados
DB_USERNAME=usuario_do_banco_de_dados
DB_PASSWORD=senha_do_usuario_do_banco_de_dados
```

Instalar as dependências do PHP
```
composer install
```

Gerar a chave
```
php artisan key:generate
```

Executar as migrations para criar a base de dados e as tabelas
```
php artisan migrate
```

Instalar as dependências do Node.js
```
npm install
```

Iniciar o projeto criado com Laravel
```
php artisan serve
```

Executar as bibliotecas Node.js
```
npm run dev
```

Acessar o conteúdo padrão do Laravel
```
http://127.0.0.1:8000
```
## Comandos do Laravel

Criar o controller
```
php artisan make:controller NomeController
```
```
php artisan make:controller UserController
```

Criar a view
```
php artisan make:view nome
```
```
php artisan make:view users/create
```

Criar um arquivo Request com validações do formulário
```
php artisan make:request NomeDoRequest
```
```
php artisan make:request UserRequest
```