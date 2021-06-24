<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Sortie;
use App\Entity\User;
use App\Form\AnnulerSortieType;
use App\Form\FiltreType;
use App\Form\SortieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class SortieController extends AbstractController
{
    #[Route('/sortie/create', name: 'sortie_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sortie = new Sortie;
        $sortieForm = $this->createForm(SortieType::class, $sortie);

        $sortieForm->handleRequest($request);

        if ($sortieForm->isSubmitted() && $sortieForm->isValid()) {
            if ($sortieForm->get('enregistrer')->isClicked()) {
                $etat = $entityManager->getRepository(Etat::class)->findOneBy(['libelle' => 'En création']);
                $this->addFlash('success', "Sortie en cours de création (Non publiée)");
            }

            if ($sortieForm->get('publier')->isClicked()) {
                $etat = $entityManager->getRepository(Etat::class)->findOneBy(['libelle' => 'Ouverte']);
                $this->addFlash('success', "Sortie publiée !");
            }
            if ($sortieForm->get('annuler')->isClicked()) {
                return $this->redirectToRoute('home');
            }
            $organisateur = $entityManager->getRepository(User::class)->find($this->getUser()->getId());
            $sortie->setEtat($etat);
            $sortie->setSite($this->getUser()->getSite());
            $sortie->setOrganisateur($organisateur);
            $entityManager->persist($sortie);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('sortie/create.html.twig', [

            'sortieForm' => $sortieForm->createView(), [

            ]

        ]);
    }

    #[Route('sortie/detail/{id}', name: 'detail_sortie', requirements: ['id' => '\d+'])]
    public function detail(int $id)
    {

        $sortie = $this->getDoctrine()->getRepository(Sortie::class)->find($id);
        if ($sortie == null) {
            throw $this->createNotFoundException("Impossible de trouver la sortie demandée");
        }

        return $this->render('sortie/details.html.twig',
            ['sortie' => $sortie]);
    }


    #[Route('/sortie/modify/{id}', name: 'sortie_modify', requirements: ['id' => '\d+'])]
    public function modify(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $sortie = $this->getDoctrine()->getRepository(Sortie::class)->find($id);
        $sortieForm = $this->createForm(SortieType::class, $sortie);

        $sortieForm->handleRequest($request);

        if ($sortieForm->isSubmitted() && $sortieForm->isValid()) {

            $entityManager->persist($sortie);
            $entityManager->flush();

            $this->addFlash('success', 'Sortie modifiée!');

            return $this->redirectToRoute('detail_sortie', ['id' => $sortie->getId()]);
        }
        return $this->render('sortie/modify.html.twig', [

            'sortieForm' => $sortieForm->createView(), [

            ]

        ]);
    }

    #[Route('home', name: 'home')]
    public function liste(EntityManagerInterface $entityManager, Request $request)
    {
        $sortieFiltreForm = $this->createForm(FiltreType::class);

        $sortieFiltreForm->handleRequest($request);

        $sortie = $this->getDoctrine()->getRepository(Sortie::class)->findAll();

        if ($sortieFiltreForm->isSubmitted() && $sortieFiltreForm->isValid()) {

            $user = $this->getDoctrine()->getRepository(User::class)->find($this->getUser());

            $nom = $sortieFiltreForm['nom']->getData();
            $debut = $sortieFiltreForm['debut']->getData();
            $fin = $sortieFiltreForm['fin']->getData();
            $passee = $sortieFiltreForm['passee']->getData();
            $site = $sortieFiltreForm['site']->getData();
            $nonInscrit = $sortieFiltreForm['non_inscrit']->getData();
            $inscrit = $sortieFiltreForm['inscrit']->getData();
            $organisateur = $sortieFiltreForm['organisateur']->getData();

            $sortie = $this->getDoctrine()->getRepository(Sortie::class)
                ->findSortieFiltered($nom, $user, $debut, $fin, $site, $passee, $nonInscrit, $inscrit, $organisateur);
        }

        return $this->render('sortie/liste.html.twig', [
            'sortie' => $sortie,
            'sortieFiltreForm' => $sortieFiltreForm->createView(), [

            ]
        ]);
    }

    #[Route('sortie/register/{id}', name: 'sortie_register', requirements: ['id' => '\d+'])]
    public function registerSortie(int $id, EntityManagerInterface $entityManager)
    {

        $inscrit = $this->getDoctrine()->getRepository(User::class)->find($this->getUser());
        $sortie = $this->getDoctrine()->getRepository(Sortie::class)->find($id);
        $sortie->add($inscrit);

        $entityManager->persist($sortie);
        $entityManager->flush($sortie);

        $this->addFlash('success', "Inscription réussie !");

        return $this->redirectToRoute('home');
    }

    #[Route('sortie/participant/registration/{id}', name: 'sortie_cancel_register', requirements: ['id' => '\d+'])]
    public function cancelRegistrationSortie(int $id, EntityManagerInterface $entityManager)
    {
        $inscrit = $this->getDoctrine()->getRepository(User::class)->find($this->getUser());
        $sortie = $this->getDoctrine()->getRepository(Sortie::class)->find($id);

        $sortie->remove($inscrit);

        $entityManager->persist($sortie);
        $entityManager->flush($sortie);

        $this->addFlash('message', 'Désincription réalisée avec succès!');
        return $this->redirectToRoute('home');
    }

    #[Route('sortie/cancel/{id}', name: 'sortie_cancel', requirements: ['id' => '\d+'])]
    public function cancelSortie(int $id, EntityManagerInterface $entityManager, Request $request)
    {
        $sortie = $this->getDoctrine()->getRepository(Sortie::class)->find($id);
        $sortieForm = $this->createForm(AnnulerSortieType::class);

        $sortieForm->handleRequest($request);

        if ($sortieForm->isSubmitted()) {
            $etat = $entityManager->getRepository(Etat::class)->findOneBy(['libelle' => 'Annulée']);
            $sortie->setEtat($etat);

            $entityManager->persist($sortie);
            $entityManager->flush($sortie);

            $this->addFlash('success', "Sortie annulée !");

            return $this->redirectToRoute('home');
        }


        return $this->render('sortie/annule.html.twig', [
            'sortie' => $sortie,
            'sortieForm' => $sortieForm->createView(), [
            ]

        ]);
    }
}
