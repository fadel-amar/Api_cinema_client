<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class, [
                'label' => 'Email',
                'required' => true,
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe',
            ]);

        // Ajoutez le champ confirmPassword uniquement si le formulaire est utilisé pour l'enregistrement
        if ($options['is_registration']) {
            $builder
                ->add('confirmPassword', PasswordType::class, [
                    'label' => 'Confirmer le mot de passe',
                ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Par défaut, le formulaire n'est pas utilisé pour l'enregistrement
            'is_registration' => false,
        ]);
    }
}
