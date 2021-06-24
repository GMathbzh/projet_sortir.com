<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Entity\Ville;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\VilleType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class VilleController extends AbstractController
{
    private $villeListe = null;

    #[Route("/ville", name:"ville")]
    public function list(Request $request, EntityManagerInterface $em)
    {
        $this->villeListe = $em->getRepository(Ville::class)->findAll();

        return $this->render('ville/index.html.twig', [
            'page_name' => 'Villes',
            'villes' => $this->villeListe
        ]);
    }

    #[Route("/ville/add", name:"add")]

    public function add(Request $request, EntityManagerInterface $em)
    {
        $ville = new Ville();
        $villeForm = $this->createForm(VilleType::class, $ville);

        $villeForm->handleRequest($request);

        if ($villeForm->isSubmitted() && $villeForm->isValid()) {

            $em->persist($ville);
            $em->flush();

            $this->addFlash('success', 'Ville ajoutée');

            return $this->redirectToRoute('ville', [
                'id' => $ville->getId(),
            ]);
        }
        return $this->render('ville/add.html.twig', [
            'form' => $villeForm->createView(),
        ]);
    }

    #[Route("/ville/{id}", name:"edit_ville")]
    public function edit(Ville $ville, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(VilleType::class, $ville);


        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $ville = $form->getData();

            $em->persist($ville);
            $em->flush();
            $this->addFlash('Success', 'La ville a bien été modifiée !');

            $this->villeListe = $em->getRepository(Ville::class)->findAll();

            return $this->redirectToRoute('ville');
        }

        return $this->render('ville/edit.html.twig', [
            'page_name' => 'Modifier une ville',
            'ville' => $ville,
            'form' => $form->createView()
        ]);
    }

    #[Route('/ville/delete/{id}', name:'delete_ville', requirements: ['id'=>'\d+'])]
    public function delete(Ville $ville, Request $request, EntityManagerInterface $em)
    {
        $ville = $em->getRepository(Ville::class)->find($request->get('id'));

        $em->remove($ville);
        $em->flush();
        $this->addFlash('Success', 'La ville a bien été supprimée !');

        return $this->redirectToRoute('ville');
    }

    #[Route('/ville/detail/{id}', name: 'ville_detail', requirements: [ 'id' => '\d+' ])]
    public function details(int $id, EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(Ville::class);
        $ville      = $repository->findOneBy(['id' => $id]);


        return $this->render('sortie/details.html.twig', [
            'ville' => $ville,
        ]);
    }

}
