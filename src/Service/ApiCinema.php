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
            "http://172.16.220.1:8000/api/films");

        return $reponseApi->toArray();
    }

    public function getFilm($id) {

        $reponseApi = $this->httpClient->request(
            "GET",
            "http://172.16.220.1:8000/api/films/$id");

        return $reponseApi->toArray();
    }

    public function registerUser ( $userData) {
        $email = $userData['email'];
        $passsword = $userData['password'];
        $confirmPassword = $userData['confirmPassword'];

        $reponseApi = $this->httpClient->request(
            "POST",
            "http://172.16.220.1:8000/api/register",
            ["json"=>[
                "email" => "$email",
                "password" => "$passsword",
                "confirmPassword" => "$confirmPassword"
            ]]);

        return $reponseApi;
    }
    public function login_check (UserModel $userModel) {
        $reponseApi = $this->httpClient->request(
            "POST",
            "http://172.16.220.1:8000/api/login_check",
            ["json"=>[
                "username" => "$userModel->email",
                "password" => "$userModel->password"
            ]]);

        return $reponseApi;
    }







}