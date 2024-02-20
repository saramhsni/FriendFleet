<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\MicroPostRepository;
use App\Repository\UserProfileRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminHomeController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin', name: 'app_admin')]
    public function index(MicroPostRepository $microPostRepo, UserRepository $userRepo, UserProfileRepository $UserProRepo): Response
    {
        $microPostCount = $microPostRepo->count([]);
        $userCount = $userRepo->count([]);
        $userProCount = $UserProRepo->count([]);
        return $this->render('admin_home/index.html.twig', [
            'microPostCount'=>$microPostCount,
            'userCount'=>$userCount,
            'userProCount'=>$userProCount
        ]);
    }
}
