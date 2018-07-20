<?php

namespace App\Service\Client;

use GuzzleHttp\Client;

class PriceService
{
    public function load()
    {
        $client = new Client([
            'base_uri' => 'http://parser.bimbilo.ru/',
            'timeout'  => 10
        ]);

        $response = $client->request('POST', '/api', [
            'form_params' => [
                'auth'   => 'bimbilo_13062018',
                'module' => 'PricesBimbilo',
                'action' => 'setPrice',
                'args'   => [1, 1, 'C:\PHP_projects\bimbilo/public/uploads/prices/33ce5cde50a251e8564378be1f2232a5.xlsx']
            ]
        ]);

        $contents = $response->getBody()->getContents();

        var_dump($contents);
        die;

//        return 'http://parser.bimbilo.ru/api/' . http_build_query($http);
    }
}