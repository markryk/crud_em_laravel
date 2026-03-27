<?php

namespace App\Http\Controllers;

use App\Jobs\ImportCsvJob;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use function Symfony\Component\Clock\now;

class ImportCSVUserController extends Controller {
    public function importCSVUsers(Request $request){

        //Validar o arquivo
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:8192', //8 MB
        ], [
            'file.required' => 'O campo arquivo é obrigatório.', 
            'file.mimes' => 'Arquivo inválido, necessário enviar arquivo CSV', 
            'file.max' => 'Tamanho do arquivo excede :max Mb'
        ]);

        try {

            //Gera um nome de arquivo baseado na data e hora atual
            $fileName = 'import-'. now()->format('Y-m-d-H-i-s') .'.csv';

            //Recebe o arquivo e move para o servidor
            $path = $request->file('file')->storeAs('uploads', $fileName);

            //Despacha o Job para processar o CSV
            ImportCsvJob::dispatch($path);

            //Redireciona o usuário, envia a mensagem de sucesso
            return back()->withInput()->with('success', 'Dados estão sendo importados!');
        
        } catch (Exception $e) {

            //Redireciona o usuário, envia a mensagem de erro
            return back()->withInput()->with('error', 'Dados não importados!');
        }
    }
}