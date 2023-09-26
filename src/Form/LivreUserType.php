<?php

namespace App\Form;

use App\Entity\Livre;
use App\Entity\LivreUser;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LivreUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            //->add('user')
            //->add('bibliotheque')
            ->add('livre', EntityType::class, [
                'class' => Livre::class,
                'choice_label' => 'nomComplet', // Remplacez par le champ de votre entité Livre que vous voulez afficher
                'multiple' => true, // Vous pouvez définir à true si vous souhaitez permettre la sélection de plusieurs livres
                'expanded' => true, // Vous pouvez définir à true si vous voulez un champ de type checkbox
            ])
            ;
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LivreUser::class,
        ]);
    }
}
