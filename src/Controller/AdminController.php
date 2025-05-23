<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AdminUserForm;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route("/admin")]
#[IsGranted("ROLE_ADMIN")]
final class AdminController extends AbstractController
{
    #[Route('', name: 'app_admin', methods: ["GET"])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('admin/index.html.twig', [
            'userCount' => $userRepository->count(),
            'verifiedUserCount' => $userRepository->count([
                'isVerified' => true
            ]),
            'adminCount' => $userRepository->countAdmins()
        ]);
    }

    #[Route('/users', name: 'app_admin_users', methods: ["GET"])]
    public function users(UserRepository $userRepository): Response
    {
        return $this->render('admin/user/index.html.twig', [
            'users' => $userRepository->findAll()
        ]);
    }

    #[Route('/users/new', name: 'app_admin_users_new', methods: ["GET", "POST"])]
    public function newUser(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager
    ): Response {
        $user = new User();
        $form = $this->createForm(AdminUserForm::class, $user, [
            "is_new_user" => true
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setCreatedAt(new \DateTimeImmutable())
                ->setIsVerified(true)
                ->setPassword(
                    $passwordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'L\'utilisateur a été créé avec succès.');
            return $this->redirectToRoute('app_admin_users');
        }

        return $this->render('admin/user/user_form.html.twig', [
            'form' => $form,
            'user' => $user
        ]);
    }

    #[Route('/users/{id}/edit', name: 'app_admin_users_edit', methods: ["GET", "POST"])]
    public function editUser(
        Request $request,
        User $user,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(AdminUserForm::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($plainPassword = $form->get('plainPassword')->getData()) {
                $user->setPassword(
                    $passwordHasher->hashPassword(
                        $user,
                        $plainPassword
                    )
                );
            }
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'L\'utilisateur a été modifié avec succès.');
            return $this->redirectToRoute('app_admin_users');
        }
        return $this->render('admin/user/user_form.html.twig', [
            'form' => $form,
            'user' => $user
        ]);
    }

    #[Route('/users/{id}/delete', name: 'app_admin_users_delete', methods: ["POST"])]
    public function deleteUser(Request $request): Response
    {
        return $this->render('admin/user/new.html.twig', []);
    }
}
