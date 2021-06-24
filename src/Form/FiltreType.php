<?php

namespace App\Form;

use App\Entity\Site;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FiltreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'required' => false,
                'mapped' => false,
                'attr' => [
                    'class' => 'form-control',

                ],
            ])
            ->add('site', EntityType::class, [
                'class' => Site::class,
                'choice_label' => 'nom',
                'required' => false,
                'mapped' => false,
                'attr' => [
                    'class' => 'form-control',

                ],
            ])
            ->add('debut', TextType::class, [
                'label' => 'Début de l\'événement',
                'required' => false,

                'attr' => [
                    'class' => 'form-control',
                    'html5' => false,
                ],

            ])
            ->add('fin', TextType::class, [
                'label' => 'Fin de l\'événement',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'html5' => false,
                ],


            ])
            ->add('organisateur', CheckboxType::class, [
                'label' => 'Je suis organisateur de la sortie',
                'required' => false,
                'mapped' => false
            ])
            ->add('inscrit', CheckboxType::class, [
                'label' => 'Je suis inscrit à la sortie',
                'required' => false,
                'mapped' => false
            ])
            ->add('non_inscrit', CheckboxType::class, [
                'label' => 'Je ne suis pas encore inscrit à la sortie ',
                'required' => false,
                'mapped' => false
            ])
            ->add('passee', CheckboxType::class, [
                'label' => 'La sortie est déjà passée',
                'required' => false,
                'mapped' => false
            ])
            ->add('valide', SubmitType::class, [
                'label' => 'Validation',
                'attr' => [
                    'class' => 'btn btn-success w-100'
                ]
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
