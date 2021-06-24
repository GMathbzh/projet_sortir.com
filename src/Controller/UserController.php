<?php


namespace App\Controller;

use App\Entity\User;
use App\Entity\Site;
use App\Form\ParticipantType;
use App\Form\RegistrationFormType;
use App\Security\LoginFormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class UserController extends AbstractController
{
    #[Route('/participant/create', name: 'user_create')]
    public function createProfil(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder)  :Response {
        $user = new User();
        $registrationForm = $this->createForm(ParticipantType::class, $user);

        $registrationForm->handleRequest($request);

        if ($registrationForm->isSubmitted() && $registrationForm->isValid()) {
            $user->setAdministrateur(1);
            $user->setActif(1);
            $hashed = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hashed);

            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'Inscription réussie!');

        }
        $repoSite = $em->getRepository(Site::class);
        $site= $repoSite->findAll();


        return $this->render('participant/create.html.twig', [
            'controller_name'  => 'ParticipantController',
            'registrationForm' => $registrationForm->createView(),
            'site' => $site

        ]);
    }

    #[Route('/participant/afficher/{id}', name: 'detail_profil', requirements: ['id' => '\d+'])]

    public function profil(int $id, EntityManagerInterface $em): Response
    {
        $repo = $em->getRepository(User::class);
        $profil = $repo->find($id);

        return $this->render('participant/profil_details.html.twig',
            ['profil'=> $profil]);
    }

    #[Route('/participant/modifier', name: 'user_modify')]
    public function modifyProfil(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder)  :Response {

        $user = $this->getDoctrine()->getRepository(User::class)->find($this->getUser());
        $registrationForm = $this->createForm(ParticipantType::class, $user);

        $registrationForm->handleRequest($request);


        if ($registrationForm->isSubmitted() && $registrationForm->isValid()) {
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'Profil modifié!');

            return $this->redirectToRoute('detail_profil', ['id'=> $this->getUser()->getId()]);
        }
        $repoSite = $em->getRepository(Site::class);
        $site= $repoSite->findAll();

        return $this->render('participant/modify.html.twig', [
            'registrationForm' => $registrationForm->createView(),
            'site' => $site

        ]);

    }

    #[Route('/participant/create', name: 'user_create')]
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $authenticator, EntityManagerInterface $em): Response
    {
        $user = new User();
        $form = $this->createForm(ParticipantType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setAdministrateur(0);
            $user->setActif(1);
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData())
            );



            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();


            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main'
            );
        }
        $repoSite = $em->getRepository(Site::class);
        $site= $repoSite->findAll();

        return $this->render('participant/create.html.twig', [
            'registrationForm' => $form->createView(),
            'site' => $site,
        ]);
    }



}

