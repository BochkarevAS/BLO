<?php

namespace App\Service\Client;

use GuzzleHttp\Client;

class PriceService
{
    public function load(array $paths)
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
                'args'   => [1, 1, $paths]
            ]
        ]);

        $contents = $response->getBody()->getContents();













//        var_dump($contents);
//        die;

//        return 'http://parser.bimbilo.ru/api/' . http_build_query($http);
    }
}