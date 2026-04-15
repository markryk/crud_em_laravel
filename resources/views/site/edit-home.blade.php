@extends('layouts.admin')

@section('content')
    <div class="content">
        <div class="content-title">
            <h1 class="page-title"> Página Inicial </h1>
            <span>
            </span>
        </div>

        <x-alert/>

        <form action="{{ route('site-home.update') }}" method="POST" class="form-container">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label for="main_title" class="form-label"> Título Principal: </label>
                <input type="text" name="main_title" id="main_title" class="form-input" placeholder="Título principal da página" value="{{ old('main_title', $homeSection->main_title ?? '') }}">
            </div>

            <div class="mb-4">
                <label for="main_description" class="form-label"> Descrição Principal: </label>
                <input type="text" name="main_description" id="main_description" class="form-input" rows="3" placeholder="Descrição principal da página" value="{{ old('main_description', $homeSection->main_description ?? '') }}">
            </div>

            <div class="mb-4">
                <label for="feature_one_title" class="form-label"> Título do recurso 1: </label>
                <input type="text" name="feature_one_title" id="feature_one_title" class="form-input" placeholder="Título do primeiro recurso" value="{{ old('feature_one_title', $homeSection->feature_one_title ?? '') }}">
            </div>

            <div class="mb-4">
                <label for="feature_one_description" class="form-label"> Descrição do recurso 1: </label>
                <textarea type="text" name="feature_one_description" id="feature_one_description" class="form-input" rows="3" placeholder="Descrição do primeiro recurso"> {{ old('feature_one_description', $homeSection->feature_one_description ?? '') }} </textarea>
            </div>

            <div class="mb-4">
                <label for="feature_two_title" class="form-label"> Título do recurso 2: </label>
                <input type="text" name="feature_two_title" id="feature_two_title" class="form-input" placeholder="Título do segundo recurso" value="{{ old('feature_two_title', $homeSection->feature_two_title ?? '') }}">
            </div>

            <div class="mb-4">
                <label for="feature_two_description" class="form-label"> Descrição do recurso 2: </label>
                <textarea type="text" name="feature_two_description" id="feature_two_description" class="form-input" rows="3" placeholder="Descrição do segundo recurso"> {{ old('feature_two_description', $homeSection->feature_two_description ?? '') }} </textarea>
            </div>

            <div class="mb-4">
                <label for="feature_three_title" class="form-label"> Título do recurso 3: </label>
                <input type="text" name="feature_three_title" id="feature_three_title" class="form-input" placeholder="Título do terceiro recurso" value="{{ old('feature_three_title', $homeSection->feature_three_title ?? '') }}">
            </div>

            <div class="mb-4">
                <label for="feature_three_description" class="form-label"> Descrição do recurso 3: </label>
                <textarea type="text" name="feature_three_description" id="feature_three_description" class="form-input" rows="3" placeholder="Descrição do terceiro recurso"> {{ old('feature_three_description', $homeSection->feature_three_description ?? '') }} </textarea>
            </div>

            <button type="submit" class="btn-warning"> Salvar </button>
        </form>
    </div>
@endsection