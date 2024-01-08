<?php
 
namespace App\Controller;
use App\Entity\User;
use DateTimeImmutable;
use App\Entity\Comment;
use App\Entity\MicroPost;
use App\Entity\UserProfile;
use App\Repository\MicroPostRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UserProfileRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class HelloController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(EntityManagerInterface $manager, MicroPostRepository $posts, AuthenticationUtils $utils): Response
    {
        $lastUsername = $utils->getLastUsername();
        $error=$utils->getLastAuthenticationError();

        // $user= new User();
        // $user->setEmail('sara@email.com');
        // $user->setPassword('12345678');

        // $profile = new UserProfile();
        // $profile->setUser($user);

        // $manager->persist($profile);
        // $manager->flush();

        // $profile= $profiles->find(1);
        // $manager->remove($profile);
        // $manager->flush();

        // $post = new MicroPost();
        // $post->setTitle('coucou');
        // $post->setText('googoolliiii');
        // $post->setCreatedAt(new DateTimeImmutable());

        // $post= $posts->find(10);
        // $comment = new Comment();
        // $comment->setText('hello i am comment');
        // $post->addComment($comment);

        // $manager->persist($comment);
        // $manager->flush();

        // $post= $posts->find(10);
        // $comment = $post->getComments()[0];
        // $post->removeComment($comment);

        // $manager->persist($comment);
        // $manager->flush();




        
        
        return $this->render('hello/index.html.twig', [
            'lastUsername'=>$lastUsername,
            'error'=>$error
        ]);
    }
}
