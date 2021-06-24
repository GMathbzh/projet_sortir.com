<?php

namespace App\Controller;

use App\Entity\Site;
use App\Form\SiteType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends AbstractController
{
    private $siteListe = null;

    #[Route("/site", name:"site")]
    public function list(Request $request, EntityManagerInterface $em)
    {
        $this->siteListe = $em->getRepository(Site::class)->findAll();

        return $this->render('site/indexSite.html.twig', [
            'page_name' => 'Sites',
            'sites' => $this->siteListe
        ]);
    }

    #[Route("/site/add", name:"add_site")]

    public function add(Request $request, EntityManagerInterface $em)
    {
        $site = new Site();
        $siteForm = $this->createForm(SiteType::class, $site);

        $siteForm->handleRequest($request);

        if ($siteForm->isSubmitted() && $siteForm->isValid()) {

            $em->persist($site);
            $em->flush();

            $this->addFlash('success', 'Site ajouté');

            return $this->redirectToRoute('site', [
                'id' => $site->getId(),
            ]);
        }
        return $this->render('site/addSite.html.twig', [
            'form_site' => $siteForm->createView(),
        ]);
    }

    #[Route("/site/{id}", name:"edit_site")]
    public function edit(Site $site, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(SiteType::class, $site);
        $form->remove('submit');

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $site = $form->getData();

            $em->persist($site);
            $em->flush();
            $this->addFlash('Success', 'Le site a bien �t� modifi� !');

            $this->siteListe = $em->getRepository(Site::class)->findAll();

            return $this->redirectToRoute('site');
        }

        return $this->render('site/editSite.html.twig', [
            'page_name' => 'Modifier un site',
            'site' => $site,
            'form_site' => $form->createView()
        ]);
    }

    #[Route('/site/delete/{id}', name:'delete_site', requirements: ['id'=>'\d+'])]
    public function delete(Site $site, Request $request, EntityManagerInterface $em)
    {
        $ville = $em->getRepository(Site::class)->find($request->get('id'));

        $em->remove($site);
        $em->flush();
        $this->addFlash('Success', 'Le site a bien �t� supprim� !');

        return $this->redirectToRoute('site');
    }
}
