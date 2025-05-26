<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\ArticleForm;
use App\Form\CommentForm;
use App\Repository\ArticleLikeRepository;
use App\Repository\ArticleRatingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/article')]
final class ArticleController extends AbstractController
{

    #[Route(path: "/", name: 'app_article_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('article/index.html.twig', []);
    }

    #[Route('/new', name: 'app_article_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleForm::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setAuthor($this->getUser());
            $article->setCreatedAt(new \DateTimeImmutable());
            $entityManager->persist($article);
            $entityManager->flush();
            $this->addFlash('success', 'Article ajouté avec succès');
            return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_article_show', methods: ['GET'])]
    public function show(
        Article $article,
        Request $request,
        ArticleLikeRepository $likeRepository,
        ArticleRatingRepository $articleRatingRepository
    ): Response {
        $ipAddress = $request->getClientIp();
        $isLiked = $likeRepository->findOneBy([
            'article' => $article,
            'ipAddress' => $ipAddress
        ]) !== null;
        $ratingIp = 0;
        $articleRating = $articleRatingRepository->findOneBy([
            'article' => $article,
            'ipAddress' => $ipAddress
        ]);
        if ($articleRating) {
            $ratingIp = $articleRating->getRating();
        }
        return $this->render('article/show.html.twig', [
            'article' => $article,
            'commentForm' => $this->createForm(CommentForm::class, new Comment()),
            "isLiked" => $isLiked,
            "ratingIp" => $ratingIp
        ]);
    }

    #[Route('/{id}/edit', name: 'app_article_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArticleForm::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Article modifié avec succès');
            return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_article_delete', methods: ['POST'])]
    public function delete(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($article);
            $entityManager->flush();
            $this->addFlash('success', 'Article supprimé avec succès');
        }

        return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
    }
}
