@extends('layouts.admin')

@section('content')
    <div class="content">
        <div class="content-title">
            <h1 class="page-title"> Editar usuário </h1>
            <span>
                <a href="{{ route('user.index') }}" class="btn-info"> Listar </a>
                <a href="#" class="btn-primary"> Visualizar </a>
            </span>
        </div>

        <x-alert/>

        <form action="{{ route('user.pwd_update', ['user' => $user->id]) }}" method="POST" class="form-container">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label for="password" class="form-label"> Nova senha: </label>
                <input type="password" name="password" id="password" class="form-input" placeholder="Senha com no mínimo 6 caracteres">
            </div>

            <button type="submit" class="btn-warning"> Salvar </button>
        </form>
    </div>
@endsection