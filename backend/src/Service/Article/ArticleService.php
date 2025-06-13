<?php

namespace App\Service\Article;

use App\Dto\ArticleDto;
use App\Dto\RequestArticleDto;
use App\Dto\RequestCommentDto;
use App\Dto\RequestRatingDto;
use App\Entity\Article;
use App\Entity\ArticleLike;
use App\Entity\ArticleRating;
use App\Entity\Comment;
use App\Entity\User;
use App\Repository\ArticleLikeRepository;
use App\Repository\ArticleRatingRepository;
use App\Repository\ArticleRepository;
use App\Service\AbstractService;
use App\Service\Category\CategoryServiceInterface;
use App\Service\Comment\CommentServiceInterface;
use App\Service\User\UserServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;

final class ArticleService extends AbstractService implements ArticleServiceInterface
{

    public function __construct(
        ArticleRepository $repository,
        private readonly Security $security,
        private readonly EntityManagerInterface $entityManager,
        private readonly UserServiceInterface $userService,
        private readonly CategoryServiceInterface $categoryService,
        private readonly ArticleLikeRepository $likeRepository,
        private readonly ArticleRatingRepository $ratingRepository,
        private readonly CommentServiceInterface $commentService
    ) {
        $this->repository = $repository;
        $this->dataTableColumns = [
            0 => 'a.id',
            1 => 'a.title',
            2 => 'categories',
            3 => 'likesCount',
            4 => 'a.createdAt',
        ];
    }

    public function paginateDataTable(Request $request, $cb): array
    {
        return [];
    }

    public function addArticle(RequestArticleDto $request): Article
    {
        $user = $this->security->getUser();
        $article = new Article();
        $article->setTitle($request->title);
        $article->setContent($request->content);
        $article->setCreatedAt(new \DateTimeImmutable());
        if ($user instanceof User) $article->setAuthor(
            $this->userService->getById($user->getId())
        );
        foreach ($request->categories as $categoryId) {
            $article->addCategory(
                $this->categoryService->getById($categoryId)
            );
        }
        $this->entityManager->persist($article);
        $this->entityManager->flush();
        return $article;
    }

    public function getLikesCountByArticle(Article $article): array
    {
        $existingLike = $this->likeRepository->findOneBy([
            'article' => $article,
            'author' => $this->getCurrentUser()
        ]);
        return [
            'liked' => $existingLike ? true : false,
            'likesCount' => $this->likeRepository->count([
                'article' => $article,
                'author' => $this->getCurrentUser()
            ]),
            'articleId' => $article->getId()
        ];
    }

    public function getRatesCountByArticle(Article $article): array
    {
        $existingRate = $this->ratingRepository->findOneBy([
            'article' => $article,
            'author' => $this->getCurrentUser()
        ]);
        return [
            'rates' => $existingRate ? $existingRate->getRating() : 0,
            'articleId' => $article->getId()
        ];
    }

    public function likeArticle(Article $article, Request $request): array
    {
        $existingLike = $this->likeRepository->findOneBy([
            "article" => $article,
            "author" => $this->getCurrentUser()
        ]);
        $liked = true;
        if ($existingLike) {
            $this->entityManager->remove($existingLike);
            $liked = false;
        } else {
            $like = new ArticleLike();
            $like->setArticle($article);
            $like->setIpAddress($request->getClientIp());
            $like->setAuthor($this->getCurrentUser());
            $like->setCreatedAt(new \DateTimeImmutable());
            $this->entityManager->persist($like);
        }
        $this->entityManager->flush();
        return [
            'liked' => $liked,
            'articleId' => $article->getId(),
            "likesCount" => $article->getLikes()->count()
        ];
    }

    public function commentArticleFromRequestCommentDto(Article $article, RequestCommentDto $request): array
    {
        $comment = new Comment();
        $comment->setArticle($article)
            ->setContent($request->content)
            ->setCreatedAt(new \DateTimeImmutable())
            ->setAuthor($this->getCurrentUser());
        $this->entityManager->persist($comment);
        $this->entityManager->flush();
        return [
            'comment' => $this->commentService->convertToDto($comment),
            'commentsCount' => $article->getComments()->count()
        ];
    }

    public function rateArticle(Article $article, RequestRatingDto $request): array
    {
        $existingRates = $this->ratingRepository->findOneBy([
            "article" => $article,
            "author" => $this->getCurrentUser()
        ]);
        $rateLength = $request->rating;
        if ($existingRates) {
            $existingRates->setRating($rateLength);
        } else {
            $rates = new ArticleRating();
            $rates->setArticle($article);
            $rates->setRating($rateLength);
            $rates->setAuthor($this->getCurrentUser());
            $rates->setIpAddress("127.0.0.1");
            $rates->setCreatedAt(new \DateTimeImmutable());
            $this->entityManager->persist($rates);
        }
        $this->entityManager->flush();
        return [
            "articleId" => $article->getId(),
            "rates" => $rateLength
        ];
    }

    public function convertToDto(Article $article): ArticleDto
    {
        $articleDto = new ArticleDto();
        $articleDto->id = $article->getId();
        $articleDto->title = $article->getTitle();
        $articleDto->content = $article->getContent();
        $articleDto->author = $this->userService->convertUserToAuthorDto($article->getAuthor());
        $articleDto->categories = $this->categoryService->convertAllToDto($article->getCategories()->toArray());
        $articleDto->createdAt = $article->getCreatedAt();
        return $articleDto;
    }

    public function convertAllToDto(array $articles): array
    {
        return array_map(
            fn($article): ArticleDto => $this->convertToDto($article),
            $articles->toArray()
        );
    }

    private function getCurrentUser(): User
    {
        $currentUser = $this->security->getUser();
        if ($currentUser instanceof User)
            return $this->userService->getById($currentUser->getId());
        return $currentUser;
    }
}
