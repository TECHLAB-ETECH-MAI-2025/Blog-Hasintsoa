<?php

namespace App\Controller\Api;

use App\Entity\Article;
use App\Entity\ArticleLike;
use App\Entity\Comment;
use App\Form\CommentForm;
use App\Repository\ArticleLikeRepository;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/articles')]
final class ArticleController extends AbstractController
{

    #[Route(path: "", name: 'api_article_index', methods: ['POST'])]
    public function index(
        ArticleRepository $articleRepository,
        Request $request
    ): JsonResponse {
        $draw = $request->request->getInt('draw');
        $start = $request->request->getInt('start');
        $length = $request->request->getInt('length');
        $search = $request->request->all('search')['value'] ?? null;
        $orders = $request->request->all('order') ?? [];
        $columns = [
            0 => 'a.id',
            1 => 'a.title',
            2 => 'categories',
            3 => 'commentsCount',
            4 => 'likesCount',
            5 => 'a.createdAt',
        ];
        $orderColumn = $columns[$orders[0]['column'] ?? 0] ?? 'a.id';
        $orderDir = $orders[0]['dir'] ?? 'desc';
        $results = $articleRepository
            ->findForDataTable($start, $length, $search, $orderColumn, $orderDir);
        $data = [];
        foreach ($results['data'] as $article) {
            $categoryNames = array_map(
                fn($category): string => $category->getTitle(),
                $article[0]->getCategories()->toArray()
            );

            $data[] = [
                'id' => $article[0]->getId(),
                'title' => sprintf(
                    '<a href="%s" class="text-decoration-none">%s</a>',
                    $this->generateUrl('app_article_show', ['id' => $article[0]->getId()]),
                    htmlspecialchars($article[0]->getTitle())
                ),
                'categories' => implode(', ', $categoryNames),
                'commentsCount' => $article["commentsCount"],
                'likesCount' => $article["likesCount"],
                'createdAt' => $article[0]->getCreatedAt()->format('d/m/Y H:i'),
                'actions' => $this->renderView('article/_actions.html.twig', [
                    'article' => $article[0]
                ])
            ];
        }
        return $this->json([
            "start" => $start,
            "length" => $length,
            "draw" => $draw,
            "recordsTotal" => $results["totalCount"],
            "recordsFiltered" => $results["filteredCount"],
            "data" => $data
        ]);
    }

    #[Route('/{id}/comment', name: 'api_article_comment', methods: ['POST'])]
    public function addComment(
        Article $article,
        Request $request,
        EntityManagerInterface $entityManager
    ): JsonResponse {
        $comment = new Comment();
        $comment->setArticle($article);
        $form = $this->createForm(CommentForm::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setCreatedAt(new \DateTimeImmutable());
            $entityManager->persist($comment);
            $entityManager->flush();
            return $this->json([
                'success' => true,
                'commentHtml' => $this->renderView('comment/_comment.html.twig', [
                    'comment' => $comment
                ]),
                'commentsCount' => $article->getComments()->count()
            ]);
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

    #[Route('/{id}/like', name: 'api_article_like', methods: ['POST'])]
    public function likeArticler(
        Article $article,
        Request $request,
        EntityManagerInterface $entityManager,
        ArticleLikeRepository $likeRepository
    ): JsonResponse {
        $ipAddress = $request->getClientIp();
        $existingLike = $likeRepository->findOneBy([
            "article" => $article,
            "ipAddress" => $ipAddress
        ]);
        $liked = true;
        if ($existingLike) {
            $entityManager->remove($existingLike);
            $liked = false;
        } else {
            $like = new ArticleLike();
            $like->setArticle($article);
            $like->setIpAddress($ipAddress);
            $like->setCreatedAt(new \DateTimeImmutable());
            $entityManager->persist($like);
        }
        $entityManager->flush();
        return $this->json([
            "success" => true,
            "liked" => $liked,
            "articleId" => $article->getId(),
            "likesCount" => $article->getLikes()->count()
        ]);
    }
}
