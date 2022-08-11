<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class LoginDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:LoginDatabase';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Procedimiento de logeo en base de datos';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {  
        $response = Http::retry(20 ,300)->post('https://10.170.20.95:50000/b1s/v1/Login',[
            'CompanyDB' => 'INVERSIONES0804',
            'UserName' => 'Prueba',
            'Password' => '1234',
        ])->json();

        $_SESSION['B1SESSION'] = '';
        return $_SESSION['B1SESSION'];
    }
}
