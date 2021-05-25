<?php

namespace App\Services;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class CallApiService
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getData(): array
    {
        /*$getToken = $this->client->request(
            'POST',
            'https://anilistmikilior1v1.p.rapidapi.com/getAccessToken'
        );

        $getToken->setHeaders([
            'content-type' => 'application/x-www-form-urlencoded',
            'x-rapidapi-key' => '4d7802f4b6msh07b72fe07074571p133070jsn5738ac32f923',
            'x-rapidapi-host' => 'Anilistmikilior1V1.p.rapidapi.com'
        ]);

        $getToken->setContentType('application/x-www-form-urlencoded');
        $getToken->setPostFields([
            'code' => '',
            'clientId' => '5528',
            'clientSecret' => 'OqhqV8bpSctmf4SouP3wth9x2Vara1RkgNnwBzBc',
            'redirectUri' => 'http://127.0.0.1:8000/'
        ]); */

        $response = $this->client->request(
            'GET',
            'https://jikan1.p.rapidapi.com/anime/16498/episodes'
        );

        $response->setHeaders([
            'x-rapidapi-key' => '4d7802f4b6msh07b72fe07074571p133070jsn5738ac32f923',
            'x-rapidapi-host' => 'jikan1.p.rapidapi.com'
        ]);

        try {
            $response = $response->send();

            echo $response->getBody();
        } catch (HttpException $ex) {
            echo $ex;
        }

        return $response->toArray();
        //return $getToken->toArray();
    }
}