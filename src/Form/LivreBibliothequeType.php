<?php

namespace App\Form;

use App\Entity\Bibliotheque;
use App\Entity\LivreBibliotheque;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LivreBibliothequeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('livre')
            ->add('bibliotheque', EntityType::class,[
                'class' => Bibliotheque::class,
                'choice_label' => 'nom',
                'label' => 'Nom de la bibliotheque'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LivreBibliotheque::class,
        ]);
    }
}
