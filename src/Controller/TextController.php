<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TextController extends AbstractController
{
    #[Route('/about', name: 'app_about')]
    public function index(): Response
    {
        return $this->render('text/about.html.twig', [
            
        ]);
    }
    #[Route('/privacy', name: 'app_privacy')]
    public function privacy(): Response
    {
        return $this->render('text/privacy.html.twig', [
            
        ]);
    }
    #[Route('/legal', name: 'app_legal')]
    public function legal(): Response
    {
        return $this->render('text/legal.html.twig', [
            
        ]);
    }
}
