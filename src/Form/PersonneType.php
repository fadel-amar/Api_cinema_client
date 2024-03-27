<?php

namespace App\Form;

use App\Model\PersonneModel;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label'=> "nom de la personne",
                "attr" =>  [
                    "placeholder"=>"nom present sur votre CNI"
                ]],
            )
            ->add('prenom', TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            "data_class" =>PersonneModel::class
        ]);
    }
}
