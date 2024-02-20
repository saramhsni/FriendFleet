<?php

namespace App\Controller;

use App\Entity\MicroPost;
use App\Form\MicroPost1Type;
use App\Repository\MicroPostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


#[IsGranted('ROLE_ADMIN')]
#[Route('/admin/micro-post')]
class AdminMicroPostController extends AbstractController
{
    #[Route('/', name: 'app_admin_micro_post_index', methods: ['GET'])]
    public function index(MicroPostRepository $microPostRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $microPostRepository->paginationQuery(),
            $request->query->get('page',1),
            5
        );
        
        return $this->render('admin_micro_post/index.html.twig', [
            
            'pagination'=>$pagination
            
        ]);
    }

    #[Route('/new', name: 'app_admin_micro_post_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,SluggerInterface $slugger): Response
    {
        $microPost = new MicroPost();
        $form = $this->createForm(MicroPost1Type::class, $microPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $postImageFile=$form->get('postImage')->getData();
            if($postImageFile){
                $originalFileName = pathinfo(
                $postImageFile->getClientOriginalName(),
                PATHINFO_FILENAME
                );

                $safeFilename=$slugger->slug($originalFileName);
                $newFileName = $safeFilename.'-'.uniqid().'.'.$postImageFile->guessExtension();

                try{
                    $postImageFile->move($this->getParameter('posts_directory'), $newFileName);
                }
                catch(FileException $e){

                }
                $microPost->setImage($newFileName);
            }
            $entityManager->persist($microPost);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_micro_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_micro_post/new.html.twig', [
            'micro_post' => $microPost,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_micro_post_show', methods: ['GET'])]
    public function show(MicroPost $microPost): Response
    {
        return $this->render('admin_micro_post/show.html.twig', [
            'micro_post' => $microPost,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_micro_post_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MicroPost $microPost, EntityManagerInterface $entityManager, SluggerInterface $slugger, MicroPostRepository $post, MicroPost $posts): Response
    {
        $form = $this->createForm(MicroPost1Type::class, $microPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $postImageFile=$form->get('postImage')->getData();
            
            if($postImageFile){
                $originalFileName = pathinfo(
                $postImageFile->getClientOriginalName(),
                PATHINFO_FILENAME
                );

                $safeFilename=$slugger->slug($originalFileName);
                $newFileName = $safeFilename.'-'.uniqid().'.'.$postImageFile->guessExtension();

                try{
                    $postImageFile->move($this->getParameter('posts_directory'), $newFileName);
                }
                catch(FileException $e){

                }
                $microPost->setImage($newFileName);
            }
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_micro_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_micro_post/edit.html.twig', [
            'micro_post' => $microPost,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_micro_post_delete', methods: ['POST'])]
    public function delete(Request $request, MicroPost $microPost, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$microPost->getId(), $request->request->get('_token'))) {
            $entityManager->remove($microPost);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_micro_post_index', [], Response::HTTP_SEE_OTHER);
    }
}
