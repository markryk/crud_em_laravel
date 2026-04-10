<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Mail\BirthdayEmail;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendBirthdayEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-birthday-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia e-mails de aniversário para os usuários aniversariantes do dia';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //Recupera a data atual
        $today = Carbon::today();

        //Filtra usuários cujo dia e mês de nascimento correspondem ao dia atual
        $users = User::whereMonth('date_of_birth', $today->month)->whereDay('date_of_birth', $today->day)->get();

        //Lê os registros retornados do banco de dados
        foreach ($users as $user) {
            Mail::to($user->email)->send(new BirthdayEmail($user));
            $this->info("Email enviado para {$user->name}");
        }
    }
}
