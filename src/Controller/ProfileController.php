<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ProfileController extends AbstractController
{
    #[Route('/profile/{id}', name: 'app_profile')]
    public function show(User $user, Request $request): Response
    {
        
        //age user active has profilesho neshon bede
        if($user->isActive()){
            return $this->render('profile/show.html.twig', [
                'user'=>$user
            ]);
        }

        return $this->redirect($request->headers->get('referer'));
        
    }

    #[Route('/profile/{id}/follows', name: 'app_profile_follows')]
    public function follows(User $user, Request $request): Response
    {
        //user active bashe followhasho neshon bede
        if($user->isActive()){

            return $this->render('profile/follows.html.twig', [
                'user'=>$user
            ]);
        }  
        return $this->redirect($request->headers->get('referer')); 
        
    }

    #[Route('/profile/{id}/followers', name: 'app_profile_followers')]
    public function followers(User $user, Request $request): Response
    {   
        if($user->isActive()){
            return $this->render('profile/followers.html.twig', [
                'user'=>$user
            ]);
        }
        return $this->redirect($request->headers->get('referer')); 
    }

    //vaghti mikhad deactive kone (toie BDD=0 mishe)
    #[Route('/profile/{id}/deactivate', name: 'app_profile_deactivate')]
   public function deactivateAccount(User $user, EntityManagerInterface $manager): Response
   {
       $user->setIsActive(false);

  
       $manager->persist($user);

       $manager->flush();

        return $this->redirectToRoute('app_login');

   }
}
