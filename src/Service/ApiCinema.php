<?php

namespace App\Service;



use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiCinema
{
    private HttpClientInterface $httpClient;

    /**
     * @param HttpClientInterface $httpClient
     */
    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }


    public function getFilmsAffiche() {

        $reponseApi = $this->httpClient->request(
            "GET",
            "http://172.16.220.1:8000/api/films");

        return $reponseApi->toArray();
    }

}