<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class SortieType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom de la sortie: ',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('dateheuredebut', TextType::class, [
                'label' => 'Date et heure de la sortie: ',
                'required' => true,
                'attr' => [
                    'html5' => false,
                    'class' => 'col-form-label',
                    'type' => 'Date',
                    'placeholder' => 'jj/mm/aaaa à hh mm ss',
                ],

            ])
            ->add('datelimiteinscription', TextType::class, [
                'label' => 'Date limite d\'inscription: ',
                'required' => true,
                'attr' => [
                    'html5' => false,
                    'class' => 'col-form-label',
                    'type' => 'Date',
                    'placeholder' => 'jj/mm/aaaa à hh mm ss',
                ],
            ])
            ->add('duree', IntegerType::class, [
                'label' => 'Durée: ',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => '90',
                ],
            ])
            ->add('nbinscriptionsmax', NumberType::class, [
                'label' => 'Nombre de places: ',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('infossortie', TextareaType::class, [
                'label' => 'Description et infos: ',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('lieu', EntityType::class, [
                'label' => 'Lieu: ',
                'class' => Lieu::class,
                'choice_label' => 'nom',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('latitude', EntityType::class, [
                'label' => 'Latitude: ',
                'mapped' => false,
                'class' => Lieu::class,
                'choice_label' => 'Latitude',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('longitude', EntityType::class, [
                'label' => 'Longitude: ',
                'mapped' => false,
                'class' => Lieu::class,
                'choice_label' => 'Longitude',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('ville', EntityType::class, [
                'label' => 'Ville:',
                'mapped' => false,
                'class' => Ville::class,
                'choice_label' => 'nom',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('enregistrer', SubmitType::class,
                ['label' => 'Enregistrer',
                    'attr' => [
                        'class' => 'btn btn-light mr-1'
                    ],
                ])
            ->add('publier', SubmitType::class,
                ['label' => 'Publier',
                    'attr' => [
                        'class' => 'btn btn-light mr-1'
                    ],
                ]);
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
