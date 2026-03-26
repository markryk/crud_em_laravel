<?php

namespace App\Http\Controllers;

use App\Http\Requests\PwdUserRequest;
use App\Http\Requests\UserRequest;
use App\Mail\UserPdfMail;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller {
    
    //Listar os usuários
    public function index(Request $request){
        //Recuperar os registros do banco de dados
        //$users = User::orderByDesc('id')->paginate(3);
        $users = User::when(
            $request->filled('name'), 
            fn($query) => 
            $query->whereLike('name', '%'.$request->name.'%')
        )->when(
            $request->filled('email'), 
            fn($query) => 
            $query->whereLike('email', '%'.$request->email.'%')
        )->when(
            $request->filled('start_date_registration'), 
            fn($query) => 
            $query->where('created_at', '>=', Carbon::parse($request->start_date_registration))
        )->when(
            $request->filled('end_date_registration'), 
            fn($query) => 
            $query->where('created_at', '<=', Carbon::parse($request->end_date_registration))
        )
        ->orderByDesc('id')
        ->paginate(10)
        ->withQueryString();

        //Carregar a view
        return view('users.index', [
            'users' => $users, 
            'name' => $request->name, 
            'email' => $request->email,
            'start_date_registration' => $request->start_date_registration, 
            'end_date_registration' => $request->end_date_registration
        ]);
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

        try {
            //Carrega a string com o conteúdo e determina a orientação e o tamanho do arquivo
            $pdf = FacadePdf::loadView('users.generate-pdf', ['user' => $user])->setPaper('a4', 'portrait');

            //Caminho temporário para salvar o arquivo
            $pdfPath = storage_path("app/public/view_user_{$user->id}.pdf");

            //Salva o PDF localmente
            $pdf->save($pdfPath);

            //Envia e-mail com o PDF anexado
            Mail::to($user->email)->send(new UserPdfMail($pdfPath, $user));

            //Remover o arquivo, após o envio do e-mail
            if(file_exists($pdfPath)){
                unlink($pdfPath);
            }

            //Redireciona o usuário, envia a mensagem de sucesso
            return redirect()->route('user.show', ['user' => $user->id])->with('success', 'Email enviado com sucesso!');

        } catch (Exception $e) {

            //Redireciona o usuário, envia a mensagem de erro
            return redirect()->route('user.show', ['user' => $user->id])->with('error', 'Email não enviado!');
        }
    }

    public function generatePdfUsers(Request $request) {
        try {
            //Recuperar os registros do banco de dados
            $users = User::when(
                $request->filled('name'), 
                fn($query) => 
                $query->whereLike('name', '%'.$request->name.'%')
            )->when(
                $request->filled('email'), 
                fn($query) => 
                $query->whereLike('email', '%'.$request->email.'%')
            )->when(
                $request->filled('start_date_registration'), 
                fn($query) => 
                $query->where('created_at', '>=', Carbon::parse($request->start_date_registration))
            )->when(
                $request->filled('end_date_registration'), 
                fn($query) => 
                $query->where('created_at', '<=', Carbon::parse($request->end_date_registration))
            )
            ->orderByDesc('name')
            ->get();

            //Somar total de registros
            $totalRecords = $users->count('id');

            //Verificar se a quantidade de registros ultrapassa o limite para gerar PDF
            $numberRecordsAllowed = 10;
            if ($totalRecords > $numberRecordsAllowed) {
                
                //Redireciona o usuário, envia a mensagem de erro
                return redirect()->route('user.index', [
                    'name' => $request->name, 
                    'email' => $request->email, 
                    'start_date_registration' => $request->start_date_registration, 
                    'end_date_registration' => $request->end_date_registration
                ])->with('error', "Limite de registros ultrapassado para gerar PDF. O limite é de $numberRecordsAllowed registros");
            }

            //Carrega a string com o conteúdo e determina a orientação e o tamanho do arquivo
            $pdf = FacadePdf::loadView('users.generate-pdf-users', ['users' => $users])->setPaper('a4', 'portrait');

            //Fazer o download do arquivo
            return $pdf->download('listar_usuarios.pdf');

        } catch (Exception $e) {

            //Redireciona o usuário, envia a mensagem de erro
            return redirect()->route('user.index', [
                'name' => $request->name, 
                'email' => $request->email, 
                'start_date_registration' => $request->start_date_registration, 
                'end_date_registration' => $request->end_date_registration
            ])->with('error', 'PDF não gerado!');
        }
    }

    public function generateCSVUsers(Request $request) {
        try {
            //Recuperar os registros do banco de dados
            //$users = User::orderByDesc('id')->get();

            //Recuperar os registros do banco de dados (de acordo com a pesquisa feita)
            $users = User::when(
                $request->filled('name'), 
                fn($query) => 
                $query->whereLike('name', '%'.$request->name.'%')
            )->when(
                $request->filled('email'), 
                fn($query) => 
                $query->whereLike('email', '%'.$request->email.'%')
            )->when(
                $request->filled('start_date_registration'), 
                fn($query) => 
                $query->where('created_at', '>=', Carbon::parse($request->start_date_registration))
            )->when(
                $request->filled('end_date_registration'), 
                fn($query) => 
                $query->where('created_at', '<=', Carbon::parse($request->end_date_registration))
            )
            ->orderByDesc('name')
            ->get();

            //Somar total de registros
            $totalRecords = $users->count('id');

            //Verificar se a quantidade de registros ultrapassa o limite para gerar CSV
            $numberRecordsAllowed = 10;
            if ($totalRecords > $numberRecordsAllowed) {
                
                //Redireciona o usuário, envia a mensagem de erro
                return redirect()->route('user.index', [
                    'name' => $request->name, 
                    'email' => $request->email, 
                    'start_date_registration' => $request->start_date_registration, 
                    'end_date_registration' => $request->end_date_registration
                ])->with('error', "Limite de registros ultrapassado para gerar CSV. O limite é de $numberRecordsAllowed registros");
            }

            //Cria o arquivo temporário
            $csvFileName = tempnam(sys_get_temp_dir(), 'csv_'.Str::ulid());

            //Abre o arquivo na forma de escrita
            $openFile = fopen($csvFileName, 'w');

            //Cria o cabeçalho do Excel
            $header = ['id', 'Nome', 'E-mail', 'Data de cadastro'];

            //Escreve o cabeçalho no arquivo
            fputcsv($openFile, $header, ';');

            //Lê os registros recuperados do banco de dados
            foreach ($users as $user) {

                //Cria o array com os dados da linha do Excel
                $userArray = [
                    'id' => $user->id, 
                    'name' => $user->name, 
                    'email' => $user->email, 
                    'created_at' => \Carbon\Carbon::parse($user->created_at)->format('d/m/Y H:i:s')
                ];

                //Escreve o conteúdo no arquivo
                fputcsv($openFile, $userArray, ';');
            }

            //Fecha o arquivo, após a escrita
            fclose($openFile);

            //Realiza o download do arquivo
            return response()->download($csvFileName, 'list_users'.Str::ulid().'.csv');
        } catch (Exception $e) {

            //Redireciona o usuário, envia a mensagem de erro
            return redirect()->route('user.index', [
                    'name' => $request->name, 
                    'email' => $request->email, 
                    'start_date_registration' => $request->start_date_registration, 
                    'end_date_registration' => $request->end_date_registration
                ])->with('error', 'CSV não gerado!');
        }
    }
}