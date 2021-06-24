<?php

namespace App\Form;

use App\Entity\Site;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ParticipantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                    'label' => 'Email',
                    'required' => true,
                    'attr' => ['placeholder' => 'mail']
                ]
            )

            ->add('plainPassword', PasswordType::class, [

                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Il faut mettre son mot de passe',
                    ]),
                    new Length([
                        'min' => 4,
                        'minMessage' => 'Your password should be at least 4 characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('username', TextType::class, [
                    'label' => 'Pseudo',
                    'required' => true,
                    'attr' => [
                        'placeholder' => 'pseudo',
                    ]]
            )
            ->add('nom', TextType::class, [
                    'label' => 'Nom',
                    'required' => true,
                    'attr' => ['placeholder' => 'nom']
                ]
            )
            ->add('prenom', TextType::class, [
                    'label' => 'Prénom',
                    'required' => true,
                    'attr' => ['placeholder' => 'prénom']
                ]
            )
            ->add('telephone', TelType::class, [
                    'label' => 'Téléphone',
                    'required' => true,
                    'attr' => ['placeholder' => 'numéro de téléphone']
                ]
            )
            ->add('username', TextType::class, [
                    'label' => 'Pseudo',
                    'required' => true,
                    'attr' => [
                        'placeholder' => 'pseudo',
                    ]]
            )
            ->add('site', EntityType::class, array(
                'class' => Site::class,
                'choice_label' => 'nom',
            ))
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter les conditions.',
                    ]),
                ],
            ])
            ->add('inscription', SubmitType::class,
                ['label' => 'S\'inscrire',
                    'attr' => [
                        'class' => 'btn btn-light mr-1'
                    ],
                ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
