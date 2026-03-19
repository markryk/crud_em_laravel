<?php

namespace App\Http\Controllers;

use App\Http\Requests\PwdUserRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF;
use Exception;

class UserController extends Controller {
    
    //Listar os usuários
    public function index(){
        //Recuperar os registros do banco de dados
        $users = User::orderByDesc('id')->paginate(3);

        //Carregar a view
        return view('users.index', ['users' => $users]);
    }

    //Detalhes do usuário
    public function show(User $user){
        //Carregar a view
        return view('users.show', ['user' => $user]);
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

            return redirect()->route('user.show', ['user' => $user->id])->with('success', 'Usuário cadastrado com sucesso!');
        } catch (Exception $e) {
            return back()->withInput()->with('error', 'Usuário não cadastrado!');
        }
    }

    //Carregar o formulário de editar usuário
    public function edit(User $user){

        //Carregar a view
        return view('users.edit', ['user' => $user]);
    }

    //Editar no banco de dados, o usuário
    public function update(UserRequest $request, User $user){
        try {
            //Editar as informações do registro no banco de dados
            $user->update([
                'name' => $request->name,
                'email' => $request->email
            ]);

            //Redireciona o usuário, envia mensagem de sucesso
            return redirect()->route('user.show', ['user' => $user->id])->with('success', 'Usuário editado com sucesso!');
        } catch (Exception $e) {
            //Redireciona o usuário, envia mensagem de erro
            return back()->withInput()->with('error', 'Usuário não editado!');
        }
    }

    //Carregar o formulário de editar senha do usuário
    public function pwd_edit(User $user){

        //Carregar a view
        return view('users.pwd_edit', ['user' => $user]);
    }

    //Salvar nova senha no banco de dados
    public function pwd_update(PwdUserRequest $request, User $user){
        try {
            //Editar as informações do registro no banco de dados
            $user->update([
                'password' => $request->password
            ]);

            //Redireciona o usuário, envia mensagem de sucesso
            return redirect()->route('user.show', ['user' => $user->id])->with('success', 'Nova senha atualizada com sucesso!');
        } catch (Exception $e) {
            //Redireciona o usuário, envia mensagem de erro
            return back()->withInput()->with('error', 'Senha não atualizada!');
        }
    }

    //Exclui o usuário do banco de dados
    public function destroy(User $user){
        try {
            //Exclui o registro do banco de dados
            $user->delete();

            //Redireciona o usuário, envia mensagem de sucesso
            return redirect()->route('user.index')->with('success', 'Usuário excluído com sucesso!');


        } catch(Exception $e) {

            //Redireciona o usuário, envia a mensagem de erro
            return redirect()->route('user.index')->with('error', 'Usuário não excluído');
        }
    }

    //Gerar PDF
    public function generatePdf(User $user) {

        //Carrega a string com o conteúdo e determina a orientação e o tamanho do arquivo
        $pdf = FacadePdf::loadView('users.generate-pdf', ['user' => $user])->setPaper('a4', 'portrait');

        //Faz o download do arquivo
        return $pdf->download('view_user.pdf');
    }
}
