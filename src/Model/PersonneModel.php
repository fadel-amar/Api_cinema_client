<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class PersonneModel
{
    #[Assert\Length(
        min: 2,
        max:30,
        minMessage : "Le nom doit faire au moins 3 caractère",
        maxMessage : "Le nom doit faire pas faire au plus 30 caractère"
    )]
    public ?string $nom = null;

    #[Assert\Length(
        min: 3,
        max:20,
        minMessage : "Le prenom est court",
        maxMessage : "Le prenom est trop long"
    )]
    public ?string $prenom = null;







}