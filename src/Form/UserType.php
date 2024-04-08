<?php

namespace App\Form;

use App\Controller\UserController;
use App\Model\UserModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class, [
                'label' => 'Adresse email',
                'required' => true,
            ])
            -> add('password', PasswordType::class, [
                'label' => 'Mot de passe',

            ])
            -> add('confirmPassword', PasswordType::class, [
                'label' => 'Confirmer le mot de passe',
            ]);

    }



}
