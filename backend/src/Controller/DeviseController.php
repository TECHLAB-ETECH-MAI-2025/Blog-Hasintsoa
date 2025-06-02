<?php

namespace App\Controller;

use App\Form\DeviseConversionForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/devise')]
final class DeviseController extends AbstractController
{
    #[Route('', name: 'app_devise')]
    public function deviseConversion(): Response {
        $form = $this->createForm(DeviseConversionForm::class);
        $form->setData([
            'exchangedate' => (new \DateTimeImmutable()),
            'fee' => 2
        ]);
        return $this->render('devise/index.html.twig', [
            'form' => $form
        ]);
    }
}
