<?php

namespace App\Service\Article;

use App\Dto\ArticleDto;
use App\Dto\AuthorDto;
use App\Dto\RequestArticleDto;
use App\Entity\Article;
use App\Entity\User;
use App\Repository\ArticleRepository;
use App\Service\AbstractService;
use App\Service\Category\CategoryServiceInterface;
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
        private readonly CategoryServiceInterface $categoryService
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
}
