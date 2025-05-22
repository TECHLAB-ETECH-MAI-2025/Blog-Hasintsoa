<?php

namespace App\Controller;

use App\Form\ProfileForm;
use App\Form\UpdatePasswordForm;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route("/profile")]
#[IsGranted("ROLE_USER")]
final class ProfileController extends AbstractController
{
    #[Route('', name: 'app_profile', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $user = $userRepository->findUserByEmail($this->getUser()->getUserIdentifier());
        $form = $this->createForm(ProfileForm::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'Votre profil a été mis à jour avec succès.');
            return $this->redirectToRoute('app_profile');
        }
        return $this->render('profile/index.html.twig', [
            'profileForm' => $form
        ]);
    }

    #[Route('/change-password', name: 'app_profile_change_password', methods: ['GET', 'POST'])]
    public function changePassword(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        UserRepository $userRepository
    ): Response {
        $form = $this->createForm(UpdatePasswordForm::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $userRepository->findUserByEmail($this->getUser()->getUserIdentifier());
            if (!$passwordHasher->isPasswordValid(
                $user,
                $form->get("currentPassword")->getData()
            )) {
                $this->addFlash('error', 'Le mot de passe actuel est incorrect.');
                return $this->redirectToRoute('app_profile_change_password');
            }
            $userRepository->upgradePassword(
                $user,
                $passwordHasher
                    ->hashPassword($user, $form->get("plainPassword")->getData())
            );
            $this->addFlash('success', 'Votre mot de passe a été modifié avec succès.');
            return $this->redirectToRoute('app_profile');
        }
        return $this->render('profile/change_password.html.twig', [
            'updatePasswordForm' => $form
        ]);
    }
}
