<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationForm;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    public function __construct(private EmailVerifier $emailVerifier) {}

    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager
    ): Response {
        if ($this->getUser()) {
            $this->addFlash("info", "Vous êtes déjà connecté");
            return $this->redirectToRoute('app_article_home');
        }
        $user = new User();
        $form = $this->createForm(RegistrationForm::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setRoles(["ROLE_USER"])
                ->setCreatedAt(new \DateTimeImmutable())
                ->setIsVerified(false);
            $plainPassword = $form->get('plainPassword')->getData();
            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));
            $entityManager->persist($user);
            $entityManager->flush();
            $this->emailVerifier->sendEmailConfirmation(
                'app_verify_email',
                $user,
                (new TemplatedEmail())
                    ->from(new Address('no-reply@domain.com', 'No Reply'))
                    ->to((string) $user->getEmail())
                    ->subject('Veuillez confirmer votre email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
            $this->addFlash("success", "Email de vérification envoyé");
            return $this->redirectToRoute('app_article_home');
        }
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(
        Request $request,
        TranslatorInterface $translator
    ): Response {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        try {
            $user = $this->getUser();
            $this->emailVerifier->handleEmailConfirmation($request, $user);
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));
            return $this->redirectToRoute('app_register');
        }
        $this->addFlash('success', 'Your email address has been verified.');
        return $this->redirectToRoute('app_article_home');
    }
}
