<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    public function __construct(
        private readonly HubInterface $hub
    ) {}

    #[Route(path: "/", name: 'app_article_home', methods: ['GET'])]
    public function index(
        ArticleRepository $articleRepository
    ): Response {
        $articles = $articleRepository->getLatestArticle(4);
        return $this->render('home/index.html.twig', [
            "articles" => $articles
        ]);
    }

    #[Route(path: '/ping', name: 'ping', methods: ['POST'])]
    public function ping(): RedirectResponse
    {
        $update = new Update("http://localhost:8000/ping", "0TestPing0");
        $this->hub->publish($update);
        return $this->redirectToRoute('app_article_home');
    }
}
