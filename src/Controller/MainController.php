<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/home', name: 'home')]
    public function index()
    {
        return $this->render('main/read.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}
