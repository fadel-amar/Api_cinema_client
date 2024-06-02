<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class ReservationModel
{

    #[Assert\NotBlank(
        message: "La quantité de la réservation est obligatoire"
    )]
    public ?int $qte = null;

}