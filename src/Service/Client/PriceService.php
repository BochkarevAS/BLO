<?php

namespace App\Service\Client;


class PriceService
{

    public function redirectToAPI()
    {
        $scope = [
            ''
        ];

        $http = [
            'redirect_uri'  => 'http://127.0.0.1:8000/receive',
            'scope'         => implode(',', $scope)
        ];

        return http_build_query($http);
    }

}