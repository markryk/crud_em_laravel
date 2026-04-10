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

## Funcionalidade de enviar e-mail

- Necessário alterar as credenciais do servidor de envio de e-mail no arquivo .env
- Pode ser usado mailtrap ou iagente
- Durante o desenvolvimento: utilizar servidor fake [Acessar envio gratuito de e-mail](https://mailtrap.io)
- No ambiente de produção: utilizar servidor Iagente [Acessar envio gratuito de e-mail](https://login.iagente.com.br/solicitacao-conta-smtp/origin/celke)
- Configurar DNS da Iagente [Acessar o tutorial](https://celke.com.br/artigo/como-configurar-o-dns-da-iagente-na-vps-da-hostinger)

Exemplo com Mailtrap
```
MAIL_MAILER=smtp
MAIL_SCHEME=null
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=nome_do_usuario
MAIL_PASSWORD=senha_do_usuario
MAIL_FROM_ADDRESS="email-remetente@meu-dominio.com"
MAIL_FROM_NAME="${APP_NAME}"
```

Exemplo com Iagente
```
MAIL_MAILER=smtp
MAIL_SCHEME=null
MAIL_HOST=smart.iagentesmtp.com.br
MAIL_PORT=587
MAIL_USERNAME=nome_do_usuario
MAIL_PASSWORD=senha_do_usuario
MAIL_FROM_ADDRESS="email-remetente@meu-dominio.com"
MAIL_FROM_NAME="${APP_NAME}"
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

Executar seed para cadastrar registros de teste
```
php artisan db:seed
```

(Comando para re-executar o seed (apaga os dados que não foram cadastrados via seed previamente))
```
php artisan migrate:fresh --seed
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

Criar seeder
```
php artisan make:seeder NomeSeeder
```
```
php artisan make:seeder UserSeeder
```

Instalar a biblioteca para apresentar o alerta personalizado.

```
npm install sweetalert2
```

Instalar a biblioteca para gerar PDF

```
composer require barryvdh/laravel-dompdf
```

Gerar a classe para enviar e-mail

```
php artisan make:mail NomeDaClasse
```
```
php artisan make:mail UserPdfMail
```

Criar o Job

```
php artisan make:job ImportCsvJob
```

Instalar a biblioteca para processar o arquivo gradativamente

```
composer require league/csv
```

Executar o Job

```
php artisan queue:work
```

Instalar o editor Summernote e o jQuery

```
npm install summernote jquery
```

## Criar CRON

Abrir o arquivo para criar um cron diretamente via terminal (SSH) na VPS

```
crontab -e
```

Criar CRON para ser executado a cada minuto
(as reticências são o caminho completo de onde está o arquivo 'script')
(digitado no terminal)

```
* * * * * php .../public/script.php
```

Intervalo de tempo usado no CRON

```
* * * * * comando
| | | | |
| | | | |_ Dia da semana (0-7) [0 e 7 = Domingo]
| | | |___ Mês (1-12)
| | |_____ Dia do mês (1-31)
| |_______ Hora (0-23)
|_________ Minuto (0-59)
```

Reiniciar o serviço de CRON (no Linux)
```
sudo service cron restart
```