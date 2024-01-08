<?php

namespace App\Controller;

use App\Entity\UserProfile;
use App\Form\UserProfile1Type;
use App\Repository\UserProfileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/user/profile')]
class AdminUserProfileController extends AbstractController
{
    #[Route('/', name: 'app_admin_user_profile_index', methods: ['GET'])]
    public function index(UserProfileRepository $userProfileRepository): Response
    {
        return $this->render('admin_user_profile/index.html.twig', [
            'user_profiles' => $userProfileRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_user_profile_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $userProfile = new UserProfile();
        $form = $this->createForm(UserProfile1Type::class, $userProfile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($userProfile);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_user_profile_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_user_profile/new.html.twig', [
            'user_profile' => $userProfile,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_user_profile_show', methods: ['GET'])]
    public function show(UserProfile $userProfile): Response
    {
        return $this->render('admin_user_profile/show.html.twig', [
            'user_profile' => $userProfile,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_user_profile_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, UserProfile $userProfile, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserProfile1Type::class, $userProfile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_user_profile_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_user_profile/edit.html.twig', [
            'user_profile' => $userProfile,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_user_profile_delete', methods: ['POST'])]
    public function delete(Request $request, UserProfile $userProfile, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$userProfile->getId(), $request->request->get('_token'))) {
            $entityManager->remove($userProfile);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_user_profile_index', [], Response::HTTP_SEE_OTHER);
    }
}
