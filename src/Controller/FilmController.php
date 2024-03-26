<?php

namespace App\Controller;

use App\Service\ApiCinema;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FilmController extends AbstractController
{
    #[Route('/films', name: 'app_films_index')]
    public function index(ApiCinema $apiCinema): Response
    {
        $films = $apiCinema->getFilmsAffiche();

        return $this->render('film/index.html.twig', ['films'=> $films]);

    }
}
