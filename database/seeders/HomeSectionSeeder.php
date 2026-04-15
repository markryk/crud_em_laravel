<?php

namespace Database\Seeders;

use App\Models\HomeSection;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class HomeSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        
        //Captura possíveis exceções durante a execução do seeder
        try {
            //Se não encontrar o registro com o nome, cadastra o registro no BD
            HomeSection::firstOrCreate(
                [], 
                [
                    'main_title' => 'Gerencie suas finanças pessoais com facilidade!', 
                    'main_description' => 'Controle seus gastos, organize seu orçamento e alcance seus objetivos financeiros.', 
                    'feature_one_title' => 'Controle simples', 
                    'feature_one_description' => 'Monitore todas as suas despesas e receitas com facilidade, garantindo total controle.', 
                    'feature_two_title' => 'Relatórios detalhados', 
                    'feature_two_description' => 'Visualize gráficos e relatórios que ajudam a entender melhor seus hábitos financeiros.', 
                    'feature_three_title' => 'Planejamento de metas', 
                    'feature_three_description' => 'Defina metas de economia e veja como seu progresso avança no dia-a-dia'
                ]
            );
        } catch (Exception $e) {
            //Salva log
            Log::notice('Conteúdo do site não cadastrado', ['error' => $e->getMessage()]);
        }
    }
}
