<?php

namespace Database\Seeders;

use App\Models\User;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Captura possíveis exceções durante a execução do seeder
        try {
            //Se não encontra o registro com o e-mail, cadastra o registro no BD
            User::firstOrCreate(
                ['email' => 'marcos@email.com'],
                [
                    'name' => 'Marcos', 
                    'email' => 'marcos.devmarcos@gmail.com', 
                    'password' => '123456', 
                    'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde sed tempora libero similique quam, voluptatibus laboriosam accusantium placeat voluptate qui eos explicabo eaque atque deleniti ex quaerat eum quasi! Itaque?'
                ]
            );

            User::firstOrCreate(
                ['email' => 'kelly@email.gmail.com'],
                [
                    'name' => 'Kelly', 
                    'email' => 'kelly@email.com', 
                    'password' => '123456', 
                    'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde sed tempora libero similique quam, voluptatibus laboriosam accusantium placeat voluptate qui eos explicabo eaque atque deleniti ex quaerat eum quasi! Itaque?'
                ]
            );

        } catch (Exception $e) {
            Log::notice('Usuário não cadastrado. ', ['error' => $e->getMessage()]);
        }
    }
}
