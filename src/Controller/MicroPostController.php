<?php

namespace App\Controller;


use App\Entity\User;
use DateTimeImmutable;
use App\Entity\Comment;
use App\Entity\MicroPost;
use App\Form\CommentType;
use App\Form\MicroPostType;
use App\Repository\UserRepository;
use App\Repository\CommentRepository;
use App\Repository\MicroPostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;



class MicroPostController extends AbstractController
{
    
    #[Route('/micro-post', name: 'app_micro_post')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function index(EntityManagerInterface $manager, MicroPostRepository $posts,User $user, UserRepository $userRepo): Response
    {
        
        $user = $this->getUser();

        //if user is deactive his account when he relog his account will be active
        $currentUser = $this->getUser();
        
        $userDb = $userRepo->findOneByEmail($currentUser->getEmail());
        
        if($currentUser && !$currentUser->isActive()){
            $userDb->setIsActive(true);
            
        }
        $manager->persist($userDb);
        $manager->flush();
        
        return $this->render('micro_post/index.html.twig', [
            'posts' => $posts->findActiveUserPosts(),
            'user'=>$user
        
        ]);
    }
    #[Route('/micro-post/top-liked', name: 'app_micro_post_topliked')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function topLiked(EntityManagerInterface $manager, MicroPostRepository $posts,User $user): Response
    {
        $user = $this->getUser();

        return $this->render('micro_post/top_liked.html.twig', [
            'posts' => $posts->findAllWithMinLikes(1000),
            'user'=>$user,
        ]);
    }
    #[Route('/micro-post/follows', name: 'app_micro_post_follows')]
    public function follows(EntityManagerInterface $manager, MicroPostRepository $posts,User $user): Response
    {
        $user = $this->getUser();

        return $this->render('micro_post/follows.html.twig', [
            'posts' => $posts->findPostsByFollows($this->getUser()),
            'user'=>$user,
        
        ]);
    }

    #[Route('/micro-post/{id}', name: 'app_micro_post_show')]
    public function showOne(MicroPostRepository $postRepository, $id): Response
    {
        
        return $this->render('micro_post/show.html.twig', [
           'post'=> $postRepository->find($id)
        ]);
    }



    #[Route('/micro-post/add', name: 'app_micro_post_add', priority:2)]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function add(Request $request, EntityManagerInterface $manager, SluggerInterface $slugger):Response
    {
        
        $microPost = new MicroPost();
        $form=$this->createForm(MicroPostType::class ,$microPost);
           
        $form->handleRequest($request);  //let the form get the data 
        if($form->isSubmitted() && $form->isValid()){
            
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
            
            $post= $form->getData();
            $post->setAuthor($this->getUser());

            $manager->persist($post);
            $manager->flush();

            $this->addFlash('success', 'Your micro post has been submited');
            return $this->redirectToRoute('app_micro_post');
            
        }
        

        return $this ->render(
            'micro_post/new.html.twig',
            [
                'form'=>$form
            ]
        
            );
    }


    #[Route('/micro-post/{id}/edit', name: 'app_micro_post_edit')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function edit(Request $request, 
    EntityManagerInterface $manager, SluggerInterface $slugger, MicroPost $post):Response
    {
       // Vérification de l'auteur du micro-post
        if ($this->getUser() !== $post->getAuthor()) {
            return $this->redirectToRoute('app_micro_post');
        }
        
        $form=$this->createForm(MicroPostType::class, $post);
         
        $form->handleRequest($request); 
        if($form->isSubmitted() && $form->isValid()){
            
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
                $post->setImage($newFileName);
            }
            
            $post= $form->getData();
            $post->setAuthor($this->getUser());

            $manager->persist($post);
            $manager->flush();

            $this->addFlash('success', 'Your micro post has been updated');
            return $this->redirectToRoute('app_micro_post');
            
        }
        return $this ->render(
            'micro_post/edit.html.twig',
            [
                'form'=>$form,
                'post'=>$post
                
            ]
        
            );
    }

    #[Route('/micro-post/{post}/delete', name: 'app_micro_post_delete')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function delete(MicroPost $post, EntityManagerInterface $manager): Response
    {
        if ($this->getUser() !== $post->getAuthor()) {
            
            $this->addFlash('error', 'You are not authorized to delete this post.');
            return $this->redirectToRoute('app_micro_post');
        }

        $manager->remove($post);
        $manager->flush();

        $this->addFlash('success', 'Your micro post has been deleted');
        return $this->redirectToRoute('app_micro_post');    
        
    }
   



# Annotations are used in Symfony to define routes and other metadata.
# In this case, it defines a route for adding a comment to a micro post.
# It expects an 'id' parameter representing the micro post, and it's named 'app_micro_post_comment'.
# The method will handle both GET and POST requests.
    #[Route('/micro-post/{id}/comment', name: 'app_micro_post_comment')]
    public function addComment(Request $request,EntityManagerInterface $manager,MicroPost $post): Response {
        # Create a form instance using CommentType and a new Comment entity.
        $form = $this->createForm(CommentType::class, new Comment());

        # Handle the request, allowing the form to fetch and validate data.
        $form->handleRequest($request);

        # Check if the form was submitted and is valid.
        if ($form->isSubmitted() && $form->isValid()) {
            # Retrieve the data from the form.
            $comment = $form->getData();
            
            # Associate the comment with the current micro post.
            $comment->setPost($post);
            $comment->setAuthor($this->getUser());

            # Persist the comment to the database.
            $manager->persist($comment);
            $manager->flush();

            # Add a flash message indicating success.
            $this->addFlash('success', 'Your comment has been submitted');

            
            # Redirect to the micro post show page after successfully submitting the comment.
            return $this->redirectToRoute('app_micro_post_show',[
                'id' => $post->getId()
                ]
            );
        }

        # If the form is not submitted or not valid, render the comment form template.
        return $this->render(
            'micro_post/comment.html.twig',
            [
                'form' => $form,
                'post' => $post
            ]
        );
    }

// edit comment
    #[Route('/micro-post/{post}/comment/{id}/edit', name: 'app_micro_post_comment_edit')]
    public function editComment(Request $request,EntityManagerInterface $manager,
    $id,Comment $comment,MicroPost $post): Response {
        
        
        # Create a form instance using CommentType and a new Comment entity.
        $form = $this->createFormBuilder($comment)
        ->add('text') 
        ->getForm();

        # Handle the request, allowing the form to fetch and validate data.
        $form->handleRequest($request);

        # Check if the form was submitted and is valid.
        if ($form->isSubmitted() && $form->isValid()) {
            # Retrieve the data from the form.
            $comment->getPost($post);
            $comment = $form ->getData();
            
            # Persist the comment to the database.
            $manager->persist($comment);
            $manager->flush();

            # Add a flash message indicating success.
            $this->addFlash('success', 'Your comment has been updated');

            # Redirect to the micro post show page after successfully submitting the comment.
            return $this->redirectToRoute('app_micro_post');
        }

        # If the form is not submitted or not valid, render the comment form template.
        return $this->render(
            'micro_post/edit_comment.html.twig',
            [
                'form' => $form,
                'post' => $post,
                'comment' =>$comment
            ]
        );
    }

    // delete comment
    #[Route('/micro-post/{post}/comment/{id}/delete', name: 'app_micro_post_comment_delete')]
    public function deleteComment(Comment $comment,EntityManagerInterface $manager): Response 
    {
        $manager ->remove($comment);
        $manager->flush();

        $this->addFlash('success', 'Comment deleted successfully');
        return $this->redirectToRoute('app_micro_post',[
            'comment'=>$comment->getId()
        ]);
    }

    


}
