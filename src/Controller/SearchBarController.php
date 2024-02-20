<?php

namespace App\Controller;

use App\Form\SearchBarType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchBarController extends AbstractController
{
    #[Route('/search_bar', name: 'app_search_bar')]
    public function search(Request $request, UserRepository $userRepository): Response
    {
        $form=$this->createForm(SearchBarType::class);
        $form->handleRequest($request);
        $user=null;
        if($form->isSubmitted()&& $form->isValid()){
            $data=$form->getData();
            
            $pseudo = $data->getPseudo();

            $user=$userRepository->findOneByPseudo($pseudo);
            
        }


        return $this->render('micro_post/index.html.twig', [
            'form'=>$form->createView(),
            'user'=>$user,
        ]);
    }
}
