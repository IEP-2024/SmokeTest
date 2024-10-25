<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;


class PerformanceTest extends Command
{
    protected $signature = 'test:performance';
    protected $description = 'Command description';
    public function __construct()
    {
        parent::__construct();
    }

    private function testCargaNormal(){
        $startTime = microtime(true);

        $url = "https://www.arqueouy.3iep.duckdns.org/html/Home.php";
        $resultado = Http::get($url);
        $endTime = microtime(true);

        $duration = $endTime - $startTime;
        $formattedTime = number_format((float)$duration, 3, '.', '');
        $this -> info($formattedTime . "s" );

        
    }

    public function handle()
    {
        $this -> testCargaNormal();
    }
}
