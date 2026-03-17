<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Exception;

class UserController extends Controller {
    
    //Listar os usuários
    public function index(){
        //Recuperar os registros do banco de dados
        $users = User::orderByDesc('id')->paginate(3);

        //Carregar a view
        return view('users.index', ['users' => $users]);
    }

    //Carrega o formulário de cadastrar novo usuário
    public function create(){

        //Carrega a view
        return view('users.create');
    }

    public function store(UserRequest $request){
        //return view('users.store');
        //dd($request);
        try {
            $user = User::create([
                'name' => $request->name, 
                'email' => $request->email, 
                'password' => $request->password
            ]);

            return redirect()->route('user.create')->with('success', 'Usuário cadastrado com sucesso!');
        } catch (Exception $e) {
            return back()->withInput()->with('error', 'Usuário não cadastrado!');
        }
    }
}
