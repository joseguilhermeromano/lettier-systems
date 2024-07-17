<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Cors implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Obter a instância da resposta
        $response = service('response');

        // Adicionar cabeçalhos CORS
        $response->setHeader('Access-Control-Allow-Origin', 'http://localhost:8081');
        $response->setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        $response->setHeader('Access-Control-Allow-Credentials', 'true');

        // Verificar se a requisição é do tipo OPTIONS
        if ($request->getMethod() == 'OPTIONS') {
            // Definir status 200 e encerrar a resposta
            $response->setStatusCode(200);
            return $response->setBody('OK')->send();
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Adicionar cabeçalhos CORS na resposta
        $response->setHeader('Access-Control-Allow-Origin', 'http://localhost:8081');
        $response->setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        $response->setHeader('Access-Control-Allow-Credentials', 'true');
    }
}
