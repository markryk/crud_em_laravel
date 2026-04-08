<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller {

    //Formulário para receber o link de recuperar senha
    public function showLinkRequestForm () {

        //Carrega a view
        return view('auth.forgot_password');

    }

    public function sendResetLinkEmail (Request $request) {

        //Valida o formulário
        $request->validate([
            'email' => 'required|email', 
        ], [
            'email.required' => 'Campo e-mail é obrigatório!',
            'email.email' => 'Necessário enviar e-mail válido!'
        ]);

        //Verificar se existe usuário no banco de dados com o e-mail
        $user = User::where('email', $request->email)->first();

        //Verifica se encontrou o usuário
        if (!$user) {
            //Redireciona o usuário, envia mensagem de erro
            return back()->withInput()->with('error', 'E-mail não encontrado!');
        }

        try {
            //Salva o token de recuperar senha e envia e-mail
            Password::sendResetLink(
                $request->only('email')
            );

            //Redireciona o usuário, e envia mensagem de sucesso
            return redirect()->route('login')->with('success', 'Enviado e-mail com instruções para recuperar a senha. Acesse a sua caixa de e-mail para recuperar a senha!');
        } catch (Exception $e) {
            
            //Redireciona o usuário, envia mensagem de erro
            return back()->withInput()->with('error', 'Tente mais tarde!');
        }
    }

    public function showRequestForm (Request $request) {
        //Carrega o formulário de atualizar senha
        try {
            //Recuperar os dados do usuário no banco de dados através do e-mail
            $user = User::where('email', $request->email)->first();

            //Verifica se encontrou o usuário no BD e se o token é válido
            if (!$user || !Password::tokenExists($user, $request->token)) {
                //Redireciona o usuário, e envia mensagem de erro
                return redirect()->route('login')->with('error', 'Token inválido ou expirado!');
            }

            //Carrega a view
            return view('auth.reset_password', ['token' => $request->token, 'email' => $request->email]);

        } catch (Exception $e) {
            //Redireciona o usuário, e envia mensagem de erro
            return redirect()->route('login')->with('error', 'Token inválido ou expirado!');
        }
    }

    public function reset (Request $request) {

        //Valida o formulário
        $request->validate([
            'email' => 'required|email|exists:users', 
            'password' => 'required|confirmed|min:6'
        ], [
            'email.required' => "Campo e-mail é obrigatório!", 
            'email.email' => 'Necessário enviar e-mail válido!', 
            'email.exists' => "E-mail inválido, utilize o e-mail cadastrado!", 
            'password.required' => "Campo senha é obrigatório!", 
            'password.confirmed' => "A confirmação da senha não corresponde!", 
            'passowrd.min' => "Senha com no mínimo :min caracteres!"
        ]);

        try {
            //Redefine a senha do usuário
            //Função only(): Recupera apenas os campos específicos do pedido
            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),

                //Retorna o callback se a redefinição de senha for bem-sucedida
                //Função forceFill(): Força o acesso à atributos protegidos
                function (User $user, string $password) {
                    $user->forceFill([
                        'password' => $password
                    ]);

                    //Salva as alterações
                    $user->save();
                }
            );

            //Redireciona o usuário, envia mensagem de sucesso (ou erro)
            return $status === Password::PASSWORD_RESET ? redirect()->route('login')->with('success', 'Senha atualizada com sucesso!') : redirect()->route('login')->with('error', 'Senha não atualizada');

        } catch (Exception $e) {
            //Redireciona o usuário e envia mensagem de erro
            return back()->withInput()->with('error', 'Tente mais tarde!');
        }
    }
}