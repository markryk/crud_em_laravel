<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller {
    //Carrega o formulário de cadastrar novo usuário
    public function create(){

        //Carrega a view
        return view('users.create');
    }

    public function store(Request $request){
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
