<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Messages;
use App\Form\MessagesType;
use Symfony\Component\Mime\Message;
use App\Repository\MessagesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MessagesController extends AbstractController
{
    #[Route('/messages', name: 'app_messages')]
    public function index(): Response
    {
        return $this->render('messages/index.html.twig', [
            'controller_name' => 'MessagesController',
        ]);
    }
    #[Route('/messages/send', name: 'app_messages_send')]
    public function send(Request $request,EntityManagerInterface $manager): Response
    {
        
        $message= new Messages;
        $form=$this->createForm(MessagesType::class ,$message);
        
        $form->handleRequest($request);  //let the form get the data 

        if($form->isSubmitted() && $form->isValid()){
            
            $message->setSender($this->getUser());
            $message->setIsRead(false);
            $message= $form->getData();

            $manager->persist($message);
            $manager->flush(); 

            $this->addFlash("Messages","Your message has been Sent");
            return $this->redirectToRoute("app_messages");
        }
        return $this->render('messages/send.html.twig', [
            'form'=>$form
        ]);
    }

    #[Route('/messages/received', name: 'app_messages_received')]
    public function received(): Response
    {
        return $this->render('messages/received.html.twig');
    }


    #[Route('/messages/read/{id}', name: 'app_messages_read')]
    public function read(Messages $message, EntityManagerInterface $manager): Response
    {
        $message->setIsRead('true');
        $manager->persist($message);
        $manager->flush(); 
         
        return $this->render('messages/read.html.twig', [
            'message'=>$message
        ]);
    }
    #[Route('/messages/delete/{id}/', name: 'app_messages_delete')]
    public function delete(Messages $message, EntityManagerInterface $manager,Request $request): Response
    {
        
        $manager->remove($message);
        $manager->flush(); 
         
        return $this->redirect($request->headers->get('referer'));
    }

    #[Route('/messages/sent', name: 'app_messages_sent')]
    public function sent(): Response
    {
        
        return $this->render('messages/sent.html.twig');
    }


    #[Route('/messages/reply/{id}', name: 'app_messages_reply')]
    public function reply(Request $request,EntityManagerInterface $manager,Messages $messages, MessagesRepository $message, $id): Response
    {
        
        $originalMessage = $manager->getRepository(Messages::class)->find($id);
        $replyMessage= new Messages();
        $replyMessage->setRecipient($originalMessage->getSender());
        $replyMessage->setSender($this->getUser());

        $form=$this->createForm(MessagesType::class ,$replyMessage);
        $form->remove('recipient');
        $form->handleRequest($request);  //let the form get the data 

        if($form->isSubmitted() && $form->isValid()){
            $replyMessage->setIsRead('false');
           

            $manager->persist($replyMessage);
            $manager->flush(); 

            $this->addFlash("Messages","Your reply has been sent");
            return $this->redirectToRoute("app_messages_sent");
        }
        return $this->render('messages/reply.html.twig', [
            'form'=>$form,
            'originalMessage'=>$originalMessage
        ]);
    }


    #[Route('/messages/send/{id}', name: 'app_messages_send_person')]
    public function sendToPerson(int $id,Request $request,EntityManagerInterface $manager): Response
    {
        $recipient = $manager->getRepository(User::class)->find($id);
        
        $message= new Messages;
        $message->setRecipient($recipient);
        $form=$this->createForm(MessagesType::class ,$message);
        $form->remove('recipient');
        
        $form->handleRequest($request);  //let the form get the data 

        if($form->isSubmitted() && $form->isValid()){
            
            $message->setSender($this->getUser());
            $message->setIsRead(false);
            $message = $form->getData();

            $manager->persist($message);
            $manager->flush(); 

            $this->addFlash("Messages","Your message has been Sent");
            return $this->redirectToRoute("app_messages");
        }
        return $this->render('messages/send.html.twig', [
            'form'=>$form,
            'recipient'=>$recipient
            
        ]);
    }

}
