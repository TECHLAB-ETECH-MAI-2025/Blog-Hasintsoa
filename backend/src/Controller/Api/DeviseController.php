<?php

namespace App\Controller\Api;

use App\Form\DeviseConversionForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[Route('/api/devise')]
final class DeviseController extends AbstractController
{

    #[Route('/calcul', 'api_calcul_devise', methods: ['POST'])]
    public function calculDevise(
        Request $request,
        HttpClientInterface $httpClient
    ): JsonResponse {
        $date = (new \DateTimeImmutable())->format('m/d/Y');
        $form = $this->createForm(DeviseConversionForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $currChange = $formData['fromCurr'];
            $formData['fromCurr'] = $formData['toCurr'];
            $formData['toCurr'] = $currChange;
            $formData['exchangedate'] = $formData['exchangedate']->format('m/d/Y');
            $response = $httpClient->request('GET', 'https://www.visa.fr/cmsapi/fx/rates', [
                'headers' => [
                    'Referer' => 'https://www.visa.fr/aide-visa/consommateur/services-de-voyage-visa/exchange-rate-calculator.html'
                ],
                'query' => [
                    ...$formData,
                    'utcConvertedDate' => $formData['exchangedate']
                ]
            ]);
            return $this->json(
                json_decode($response->getContent())
            );
        }

        $errors = [];
        foreach ($form->getErrors(true) as $error) {
            $errors[$error->getOrigin()->getName()] = $error->getMessage();
        }

        return $this->json([
            'success' => false,
            'error' => count($errors) > 0 ? $errors : 'Formulaire invalide'
        ], Response::HTTP_BAD_REQUEST);
    }
}
