<?php

namespace App\Controller;


use App\Form\UserType;
use App\Model\UserModel;
use App\Service\ApiCinema;
use App\Service\ApiLogin;
use http\Client\Response;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;


class UserController extends AbstractController
{
    #[\Symfony\Component\Routing\Attribute\Route('/register', name: 'app_register')]
    #[Route('/', name: 'register')]
    public function register(Request $request, ApiCinema $apiCinema)
    {
        $form = $this->createForm(UserType::class, null, ['is_registration' => true]);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $userData = $form->getData();
            $response = $apiCinema->registerUser($userData);

            $statut = $response->getStatusCode();
            $content = json_decode($response->getContent(false),true);

            if ($statut == 201) {
                $this->addFlash("success", "Votre compte a bien été crée");
                return $this->redirectToRoute('app_films_index');
            } else {
                $errors = $content['errors'];

                if (isset($errors['email'])) {
                    $erreursMail = $errors["email"];
                    $form['email']->addError(new FormError($erreursMail));
                }

                if (isset($errors['password'])) {
                    $erreurPassword = $errors["password"];
                    $form['password']->addError(new FormError($erreurPassword));
                }
            }
        }

        return $this->render('user/register.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     */
    #[Route('/login', name: 'app_login')]
    public function login(RequestStack $request, ApiCinema $apiCinema): \Symfony\Component\HttpFoundation\Response
    {
        $user = new UserModel();
        // Créer le formulaire
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request->getCurrentRequest());
        $content = null;

        $session = $request->getSession();
        $sessionData = $session->all();

        if($form->isSubmitted() && $form->isValid()) {

            $session = $request->getSession();
            $sessionData = $session->all();

            $response = $apiCinema->login_check($user);


            $statut = $response->getStatusCode();
            $content = json_decode($response->getContent(false),true);

            if ($statut === 401) {
                $this->addFlash('danger', 'Identifiants incorrects');
                return $this->redirectToRoute('app_login');
            } else {
                $request->getSession()->set('token', (($response->toArray())['token']));
                $this->addFlash("success", "Vous êtes bien authentifié");
                return $this->redirectToRoute("app_films_index");
            }

        }

        return $this->render('user/login.html.twig', [
            'form' => $form,
        ]);
    }
}