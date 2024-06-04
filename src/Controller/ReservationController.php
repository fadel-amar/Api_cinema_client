<?php

namespace App\Controller;

use App\Form\ReservationType;
use App\Model\ReservationModel;
use App\Service\ApiCinema;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    #[Route('/reservations/{id}', name: 'api_film_reservation', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function showSeance(ApiCinema $apiCinema, RequestStack $request, $id): Response
    {

        $responseGET = $apiCinema->reserver('GET', $id);
        if ($responseGET->getStatusCode() == 401) {
            $this->addFlash("danger", "Connectez-vous pour réaliser cette action");
            return $this->redirectToRoute('app_films_index');
        }

        $getSeance = $responseGET->toArray();


        $reservation = new ReservationModel();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request->getCurrentRequest());

        $statut = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $response = $apiCinema->reserver('POST', $id, $reservation);
            $statut = $response->getStatusCode();
            $content = json_decode($response->getContent(false), true);

            if ($statut == 201) {
                $filmTitre = $getSeance['film']['titre'];
                $dateSeance = $getSeance['dateProjection'];
                $dateTime = new \DateTime($dateSeance);
                $dateFormatted = $dateTime->format('d/m/Y  H:i');

                $qte = $reservation->qte;
                $this->addFlash("success", "Votre réservation de $qte place(s) a bien été transmise pour le film  $filmTitre  le $dateFormatted  ");
                return $this->redirectToRoute('app_films_index');
            } else {
                $form->addError(new FormError($content['errors']));
            }
        }


        return $this->render('reservation/index.html.twig', [
            'form' => $form,
            'seance' => $getSeance ?? null,
        ]);
    }
}
