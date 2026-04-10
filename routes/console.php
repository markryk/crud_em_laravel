<?php
    use Illuminate\Support\Facades\Schedule;

    //Executar a tarefa acada minuto
    Schedule::command('app:send-birthday-email')->everyMinute();

    //Executar a tarefa uma vez ao dia, às 08:00
    //Schedule::command('app:send-birthday-email')->dailyAt('11:10')->description('Enviar e-mail diariamente no horário predefinido');

    /*use Illuminate\Foundation\Inspiring;
    use Illuminate\Support\Facades\Artisan;

    Artisan::command('inspire', function () {
        $this->comment(Inspiring::quote());
    })->purpose('Display an inspiring quote');*/

?>