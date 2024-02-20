<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserProfile;
use App\Form\UserProfileType;
use App\Form\ProfileImageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class SettingProfileContoller extends AbstractController
{
    #[Route('/setting/profile', name: 'app_setting_profile')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function profile(Request $request, EntityManagerInterface $entityManager): Response
    {   
        /** @var User $user */
        
        $user = $this->getUser();
        $userProfile = $user->getUserProfile() ?? new UserProfile;

        $form = $this->createForm(UserProfileType::class, $userProfile);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $userProfile= $form->getData();
            $user->setUserProfile($userProfile);
                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash('success','Your user profile settings were saved successfully');
                return $this->redirectToRoute(
                    'app_profile',['id' => $user->getId()]
                );
        }


        return $this->render('setting_profile/profile.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/setting/profile_image', name: 'app_setting_profile_image')]
    public function profileImage(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    { 
        $form = $this->createForm(ProfileImageType::class);
        /** @var User $user */
        $user = $this->getUser();
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){

            $profileImageFile = $form->get('profileImage')->getData();

            //inja mige age profile image upload shod, bia az toie un esm faghat esme aslio bedon extension begir vasam
            //toie $profileImageFile save kon
            if($profileImageFile){
                $originalFileName = pathinfo(
                    $profileImageFile->getClientOriginalName(),
                    PATHINFO_FILENAME
                );
                //halla inja mige un $profileImageFile ro vasam tamiz kon masalan be jaie space vasam - bezar va ie unique id bhesh bede
                //va extension ro ham khodet hads bezan ke chie
                $safeFilename = $slugger->slug($originalFileName);
                $newFileName = $safeFilename . '-' . uniqid() . '.' . $profileImageFile->guessExtension();

                try {
                    //halla ke un image ro gereftio esmesho avaz kardi biar movesh kon vasam toie public/upload
                    //ke in chemin ro toie service.yaml parameters be name 'profiles_directory' moshakhas kardim
                    $profileImageFile->move($this->getParameter('profiles_directory'),$newFileName);
                } catch (FileException $e){

                }

                //age ghablan profile dare uno begir age na ie done jadid vasash besaz
                $profile = $user->getUserProfile() ?? new UserProfile();
                $profile->setImage($newFileName);
                $user->setUserProfile($profile);

                $entityManager->persist($user);
                $entityManager->flush();

                //add flash et redirection
                $this->addFlash('success','your profile Image has been updated successfully');
                return $this->redirectToRoute('app_setting_profile_image');
            }

        }


        return $this->render('setting_profile/profile_image.html.twig', [
            'form' => $form->createView(),
        ]);
    }


}
