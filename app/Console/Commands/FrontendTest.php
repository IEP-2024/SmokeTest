<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FrontendTest extends Command
{

    protected $signature = 'test:frontend';
    protected $description = 'Command description';
    public function __construct()
    {
        parent::__construct();
    }

    private function testRedirect(){
        $url = "https://www.arqueouy.3iep.duckdns.org/";
        $resultado = Http::withoutRedirecting($url) -> get($url) -> redirect() ? "OK" : "ERROR";
        return ["Redirect", $resultado];
    }

    private function testCargaNormal(){
        $url = "https://www.arqueouy.3iep.duckdns.org/html/Home.php";
        $resultado = Http::get($url) -> successful() ? "OK" : "ERROR";
        return ["Carga Normal", $resultado];
        
    }

    public function handle()
    {      
        $tests = [];
        array_push($tests,$this->testRedirect());
        array_push($tests,$this->testCargaNormal());

        $this->table(
            ["Componente", 'Status'],
            $tests
        );

        return 0;
    }
}
