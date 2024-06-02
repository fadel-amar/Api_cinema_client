<?php

namespace App\Service;


use App\Model\ReservationModel;
use App\Model\UserModel;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Security;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiCinema
{
    private HttpClientInterface $httpClient;
    private RequestStack $request;


    /**
     * @param HttpClientInterface $httpClient
     * @param RequestStack $request
     */
    public function __construct(HttpClientInterface $httpClient, RequestStack $request)
    {
        $this->httpClient = $httpClient;
        $this->request = $request;
    }


    public function getFilmsAffiche()
    {

        $reponseApi = $this->httpClient->request(
            "GET",
            "http://localhost:8000/api/films");

        return $reponseApi->toArray();
    }

    public function getFilm($id)
    {

        $reponseApi = $this->httpClient->request(
            "GET",
            "http://localhost:8000/api/films/$id");

        return $reponseApi->toArray();
    }

    public function registerUser($userData)
    {
        $email = $userData['email'];
        $passsword = $userData['password'];
        $confirmPassword = $userData['confirmPassword'];

        $reponseApi = $this->httpClient->request(
            "POST",
            "http://localhost:8000/api/register",
            ["json" => [
                "email" => "$email",
                "password" => "$passsword",
                "confirmPassword" => "$confirmPassword"
            ]]);

        return $reponseApi;
    }

    public function login_check(UserModel $userModel)
    {
        $reponseApi = $this->httpClient->request(
            "POST",
            "http://localhost:8000/api/login_check",
            ["json" => [
                "username" => "$userModel->email",
                "password" => "$userModel->password"
            ]]);

        return $reponseApi;
    }


    public function reserver( $method ,$id , ?ReservationModel $reservationModel=null)
    {


        $token = $this->request->getCurrentRequest()->getSession()->get('token');
        $options = [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ],
        ];


        if($method == 'POST') {

            $options = [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                ],
                'json' => [
                    'idSeance' => $id,
                    'nbPlacesReserver' => $reservationModel->qte,
                ],
            ];


            $reponseApi = $this->httpClient->request(
                "POST",
                "http://localhost:8000/api/reservations/$id",
                $options
            );

        } else {

            $reponseApi = $this->httpClient->request(
                "GET",
                "http://localhost:8000/api/reservations/$id",
                $options
            );
        }


        return $reponseApi;
    }


}