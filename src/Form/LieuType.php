<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormTypeInterface;

class LieuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ville', EntityType::class, [
                'label' => 'Ville: ',
                'class' => Ville::class,
                'choice_label' => 'nom',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                ],])
            ->add('nom', TextType::class, [
                'label' => 'Lieu: ',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('rue', TextType::class, [
                'label' => 'Rue: ',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('latitude', IntegerType::class, [
                'label' => 'Latitude: ',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('longitude', IntegerType::class, [
                'label' => 'Longitude: ',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Lieu::class,
        ]);
    }
}
