<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Cadastrar </title>
</head>
<body>
    <h1> Cadastrar Usuário </h1>

    @if (session('success'))
        <p style="color: #086">
            {{ session('success') }}
        </p>
    @endif

    @if (session('error'))
        <p style="color: #f00">
            {{ session('error') }}
        </p>
    @endif

    <form action="{{ route('user.store') }}" method="POST">
        @csrf

        <label for="name" class="form-label"> Nome: </label>
        <input type="text" name="name" id="name" class="form-input" placeholder="Nome completo" value="{{ old('name') }}" required>
        <br><br>

        <label for="email" class="form-label"> Email: </label>
        <input type="email" name="email" id="email" class="form-input" placeholder="Seu melhor email" value="{{ old('email') }}" required>
        <br><br>

        <label for="password" class="form-label"> Senha: </label>
        <input type="password" name="password" id="password" class="form-input" placeholder="Senha com no mínimo 6 caracteres" value="{{ old('password') }}" required>
        <br><br>

        <button type="submit" class="btn-success"> Cadastrar </button>
    </form>
</body>
</html>