@extends('layouts.login')

@section('content')
    <h1 class="title-login"> Área restrita </h1>

    <x-alert/>

    <form class="mt-4" action="{{ route('login.process') }}" method="post">
        @csrf
        @method('POST')
        
        <div class="form-group-login">
            <label for="email" class="form-label-login"> E-mail </label>
            <input type="email" name="email" id="email" placeholder="Digite o e-mail de usuário" class="form-input-login" value="{{ old('email') }}" required>
        </div>

        <div class="form-group-login">
            <label for="password" class="form-label-login"> Senha </label>
            <input type="password" name="password" id="password" placeholder="Digite a senha" class="form-input-login" value="{{ old('password') }}" required>
        </div>

        <!-- Link para recuperação de senha e botão de login -->
        <div class="btn-group-login">
            <a href="#" class="link-login"> Esqueceu a senha? </a>
            <button type="submit" class="btn-primary-md"> Acessar </button>
        </div>

        <div class="mt-4 text-center">
            <a href="#" class="link-login"> Criar nova conta! </a>
        </div>

        <!-- Informações de login -->
        <div class="mt-4 text-center text-sm text-gray-600">
            <p> Usuário: marcos.devmarcos@gmail.com </p>
            <p> Senha: 123456 </p>
        </div>
    </form>
@endsection