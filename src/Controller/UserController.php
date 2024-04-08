<?php

namespace App\Controller;


use App\Form\UserType;
use App\Service\ApiCinema;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[\Symfony\Component\Routing\Attribute\Route('/register', name: 'app_register')]
    #[Route('/', name: 'register')]
    public function register(Request $request, ApiCinema $apiCinema)
    {
        $form = $this->createForm(UserType::class, []);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $userData = $form->getData();

            $response = $apiCinema->registerUser($userData);

            $statut = $response->getStatusCode();
            $content = json_decode($response->getContent(false), true);

            if ($statut == 201) {

                return $this->redirectToRoute('home');

            } else {
                $errors = $content[0];
                foreach ($errors as $error) {
                    $form = $form->addError(new FormError($error));
                }

            }



        }

        return $this->render('user/register.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'User'
        ]);
    }
}