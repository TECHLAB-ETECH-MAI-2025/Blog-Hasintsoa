<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route(path: "/", name: 'app_article_home', methods: ['GET'])]
    public function index(
        ArticleRepository $articleRepository,
        Request $request
    ): Response {
        $page = $request->query->getInt("page", 1);
        $articles = $articleRepository->paginateArticles($page, 2);
        return $this->render('home/index.html.twig', [
            'articles' => $articles,
        ]);
    }
}
