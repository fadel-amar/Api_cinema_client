<?php

namespace App\Service;



use App\Model\UserModel;
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
            "http://localhost:8000/api/films");

        return $reponseApi->toArray();
    }

    public function getFilm($id) {

        $reponseApi = $this->httpClient->request(
            "GET",
            "http://localhost:8000/api/films/$id");

        return $reponseApi->toArray();
    }

    public function registerUser ( $userData) {
        $email = $userData['email'];
        $passsword = $userData['password'];
        $confirmPassword = $userData['confirmPassword'];

        $reponseApi = $this->httpClient->request(
            "POST",
            "http://localhost:8000/api/register",
            ["json"=>[
                "email" => "$email",
                "password" => "$passsword",
                "confirmPassword" => "$confirmPassword"
            ]]);

        return $reponseApi;
    }







}