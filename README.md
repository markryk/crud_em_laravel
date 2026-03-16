CRUD com Laravel 12 (cadastrar, listar, editar e apagar)

## Requisitos

* PHP8.2 ou superior (conferir versão: php -v)
* Composer (conferir versão: composer --version)
* Node.js 22 ou superior (conferir versão: node -v)
* Git (conferir versão: git -v)

## Sequência para criar o projeto

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

## Rodar o projeto

- Baixar os arquivos do GitHub
```
git clone <repositorio_url>
```

- Duplicar o arquivo ".env.example" e renomear para ".env".

Instalar as dependências do PHP
```
composer install
```

Gerar a chave
```
php artisan key:generate
```

Iniciar o projeto criado com Laravel
```
php artisan serve
```

Acessar o conteúdo padrão do Laravel
```
http://127.0.0.1:8000
```

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

Executar as migrations para criar a base de dados e as tabelas
```
php artisan migrate
```