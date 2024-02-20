<?php

namespace App\Controller;

use App\Entity\MicroPost;
use App\Repository\UserRepository;
use App\Repository\MicroPostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class LikeController extends AbstractController
{
    #[Route('/like/{id}', name: 'app_like')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function like(MicroPost $post, $id, EntityManagerInterface $manager, Request $request): Response
    {
       
        $currentUser = $this->getUser();
        $post->addLikedBy($currentUser);

        $manager->persist($post);
        $manager->flush();

        return $this->redirect($request->headers->get('referer').'#detail'.$id);
    }

    #[Route('/unlike/{id}', name: 'app_unlike')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function unlike(MicroPost $post, MicroPostRepository $posts, $id, EntityManagerInterface $manager, Request $request): Response
    {
        
        $currentUser = $this->getUser();
        $post->removeLikedBy($currentUser);

        $manager->persist($post);
        $manager->flush();

        return $this->redirect($request->headers->get('referer').'#detail'.$id);
        
    }
}
