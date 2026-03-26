<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use function Symfony\Component\Clock\now;

class ImportCSVUserController extends Controller {
    public function importCSVUsers(Request $request){
        try {

            //Validar o arquivo
            $request->validate([
                'file' => 'required|mimes:csv,txt|max:2048',
            ], [
                'file.required' => 'O campo arquivo é obrigatório.', 
                'file.mimes' => 'Arquivo inválido, necessário enviar arquivo CSV', 
                'file.max' => 'Tamanho do arquivo excede :max Mb'
            ]);

            //Cria o array com as colunas no banco de dados
            $headers = ['name', 'email', 'password'];

            //Recebe o arquivo, ler os dados e converte a string em array
            $fileData = array_map('str_getcsv', file($request->file('file')));

            //Define o separador dos valores CSV
            $separator = ';';

            //Cria array para armazenar os valores que serão inseridos no banco
            $arrayValues = [];

            //Cria array para armazenar e-mails duplicados encontrados
            $duplicatedEmails = [];

            //Cria variável para contar o número de registros que serão cadastrados
            $numberRegisteredRecords = 0;

            //Percorre cada linha do arquivo CSV
            foreach ($fileData as $row) {

                //Separa os valores da linha utilizando o separador
                $values = explode($separator, $row[0]);

                //Verifica se a quantidade de valores corresponde ao número de colunas esperadas
                if (count($values) !== count($headers)) {
                    continue; //Ignora linhas inválidas
                }

                //Combina os valores com o nome das colunas (cabeçalhos)
                $userData = array_combine($headers, $values);

                //Consulta apenas o e-mail atual para verificar se já existe no banco de dados
                $emailExists = User::where('email', $userData['email'])->exists();

                //Se o e-mail já existir, adiciona na lista de e-mails duplicados e pula para a próxima linha
                if ($emailExists) {
                    $duplicatedEmails[] = $userData['email'];
                    continue;
                }

                //Adiciona o usuário ao array de valores para serem inseridos
                $arrayValues[] = [
                    'name' => $userData['name'], 
                    'email' => $userData['email'], 
                    'password' => Hash::make(Str::random(7), ['rounds' => 12]), 
                    'created_at' => now(),
                    'updated_at' => now()
                ];

                //Incrementa o contador de registros que serão cadastrados
                $numberRegisteredRecords++;
            }
            
            //Verifica se existe e-mail já cadastrado, retorna erro e não cadastra no banco de dados
            if (!empty($duplicatedEmails)) {
                //Redireciona o usuário, envia mensagem de erro
                return back()->with('error', 'Dados não importados. Existem e-mails já cadastrados: <br>'.implode(', ', $duplicatedEmails));
            }

            //Cadastra registros no banco de dados
            User::insert($arrayValues);

            //Redireciona o usuário, envia mensagem de sucesso
            return back()->with('success', 'Dados importados com sucesso. <br> Quantidade: '.$numberRegisteredRecords);

        } catch (Exception $e) {

            //Redireciona o usuário, envia a mensagem de erro
            return back()->withInput()->with('error', 'Dados não importados!');
        }
    }
}