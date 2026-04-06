<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller {

    public function index() {
        
        //Carrega a view
        return view('auth.login');
    }

    //Valida os dados do usuário no login
    public function loginProcess(AuthLoginRequest $request) {
        
        //Captura possíveis durante a execução
        try {
            //Valida o usuário e a senha com as informações do banco de dados
            $authenticated = Auth::attempt([
                'email' => $request->email, 
                'password' => $request->password
            ]);

            //Verifica se o usuário foi autenticado
            if (!$authenticated) {
                //Redireciona o usuário, envia mensagem de erro
                return back()->withInput()->with('error', 'Email ou senha inválido!');
            }

            //Redireciona o usuário
            return redirect()->route('user.index');

        } catch (Exception $e) {
            //Redireciona o usuário, envia mensagem de erro
            return back()->withInput()->with('error', 'Email ou senha inválido!');
        }
    }

    //Deslogar o usuário
    public function logout() {

        //Deslogar o usuário
        Auth::logout();

        //Redireciona o usuário, envia mensagem de sucesso
        return redirect()->route('login')->with('success', 'Deslogado com sucesso!');
    }
    
}
