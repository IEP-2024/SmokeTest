<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;


class ApiTest extends Command
{

    protected $signature = 'test:Api';
    protected $description = 'Command description';
    public function __construct()
    {
        parent::__construct();
    }

    private function login(){
        $url = "https://api.arqueouy.3iep.duckdns.org/api/auth/login";
        $credenciales = [
            "name" => "UsuarioAPI",
            "password" => "API2024"
        ];
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
        $respuesta = json_decode(
            Http::withHeaders($headers) 
                -> post($url,$credenciales) 
                -> body(), 
            true);

        return $respuesta['access_token'];
    }

    private function testBaseDeDatos(){
        $url = "https://api.arqueouy.3iep.duckdns.org/api/inventario";
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'bearer ' . $this -> login()
        ];
        $resultado = Http::withHeaders($headers) -> get($url) -> successful() ? "OK" : "ERROR";
        return ["BD", $resultado];
    }

    private function testRedis(){
        $url = "https://api.arqueouy.3iep.duckdns.org/api/mapa";
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'bearer ' . $this -> login()
        ];
        $resultado = Http::withHeaders($headers) -> get($url) -> successful() ? "OK" : "ERROR";
        return ["redis", $resultado];
    }
    public function handle()
    {
        $tests = [];
        array_push($tests,$this -> testBaseDeDatos());
        array_push($tests,$this -> testRedis());

        $this->table(
            ['Componente', 'Status'],
            $tests
        );
        return 0;
    }
}
