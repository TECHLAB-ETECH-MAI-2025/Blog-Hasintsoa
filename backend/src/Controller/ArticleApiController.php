<?php

namespace App\Controller;

use App\Dto\RequestRatingDto;
use App\Entity\Article;
use App\Entity\ArticleRating;
use App\Entity\Comment;
use App\Entity\User;
use App\Form\CommentForm;
use App\Repository\ArticleRatingRepository;
use App\Repository\ArticleRepository;
use App\Service\Article\ArticleServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('app/articles')]
final class ArticleApiController extends AbstractController
{
    public function __construct(
        private readonly ArticleServiceInterface $articleService
    ) {}

    #[Route(path: "/data-table", name: 'app_article_data', methods: ['POST'])]
    public function listForDataTable(
        ArticleRepository $articleRepository,
        Request $request
    ): JsonResponse {
        $draw = $request->request->getInt('draw');
        $start = $request->request->getInt('start', 0);
        $length = $request->request->getInt('length', 10);
        $search = $request->request->all('search')['value'] ?? null;
        $orders = $request->request->all('order') ?? [];
        $columns = [
            0 => 'a.id',
            1 => 'a.title',
            2 => 'categories',
            3 => 'likesCount',
            4 => 'a.createdAt',
        ];
        $orderColumn = $columns[$orders[0]['column'] ?? 0] ?? 'a.id';
        $orderDir = $orders[0]['dir'] ?? 'desc';
        $user = $this->getUser();
        if ($user instanceof User) {
            $results = $articleRepository
                ->findForDataTable(
                    $start,
                    $length,
                    $search,
                    $orderColumn,
                    $orderDir,
                    $this->isGranted('ROLE_ADMIN') ? null : $user->getId()
                );
        }
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
                'likesCount' => $article["likesCount"],
                'createdAt' => $article[0]->getCreatedAt()->format('d/m/Y H:i'),
                'actions' => $this->renderView('article/_actions.html.twig', [
                    'article' => $article[0]
                ])
            ];
        }
        return $this->json([
            "draw" => $draw,
            "recordsTotal" => $results["totalCount"],
            "recordsFiltered" => $results["totalCount"],
            "data" => $data
        ]);
    }

    #[Route('/{id}/comment', name: 'app_article_comment', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function commentArticle(
        Article $article,
        Request $request,
        EntityManagerInterface $entityManager
    ): JsonResponse {
        $comment = new Comment();
        $comment->setArticle($article);
        $form = $this->createForm(CommentForm::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $currentUser = $this->getUser();
            if ($currentUser instanceof User)
                $user = $entityManager->getRepository(User::class)->findOneBy([
                    'id' => $currentUser->getId()
                ]);
            $comment->setAuthor($user);
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

    #[Route('/{id}/like', name: 'app_article_like', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function likeArticle(
        Article $article,
        Request $request
    ): JsonResponse {
        return $this->json($this->articleService->likeArticle($article, $request));
    }

    #[Route('/{id}/rate', name: 'app_article_rate', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function rateArticle(
        Article $article,
        #[MapRequestPayload]
        RequestRatingDto $request
    ): JsonResponse {
        return $this->json(
            $this->articleService->rateArticle($article, $request)
        );
    }
}
