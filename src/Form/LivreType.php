<?php

namespace App\Form;

use App\Entity\Auteur;
use App\Entity\Edition;
use App\Entity\Genre;
use App\Entity\Langue;
use App\Entity\Livre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('cycle')
            ->add('tome')
            ->add('titre')
            ->add('genres', EntityType::class, [
                'class' => Genre::class,
                'choice_label' => 'libelle',
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false,
            ])
            ->add('auteurs', EntityType::class, [
                'class' => Auteur::class,
                'choice_label' => 'prenomNom',
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false,
            ])
            ->add('langue', EntityType::class, [
                'class' => Langue::class,
                'choice_label' => 'libelle',
            ])
            ->add('edition', EntityType::class, [
                'class' => Edition::class,
                'choice_label' => 'libelle',
            ])
            ->add('resume')
            ->add('couverture', FileType::class, [
                'label' => 'Couverture du livre',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'Veillez télécharger un PNG ou un JPEG',
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,
        ]);
    }
}
