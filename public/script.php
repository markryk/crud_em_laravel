<?php
    //Define o caminho do autoload do Laravel
    require __DIR__ . '/../vendor/autoload.php';

    $app = require_once __DIR__ . '/../bootstrap/app.php';

    //Cria a instância do kernel HTTP
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

    //Cria uma request simulada para a rota que executa a controller
    $request = Illuminate\Http\Client\Request::create('/generate-user', 'GET');

    //Executa a aplicação e captura a resposta
    $response = $kernel->handle($request);

    //Imprime o resultado (opcional)
    echo $response->getContent();

    //Encerra o kernel
    $kernel->terminate($request, $response);
?>