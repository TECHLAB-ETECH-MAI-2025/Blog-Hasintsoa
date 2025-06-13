<?php

namespace App\Service\User;

use App\Dto\AuthorDto;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\AbstractService;

final class UserService extends AbstractService implements UserServiceInterface
{
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
        $this->dataTableColumns = [
            0 => 'id',
            1 => 'lastName',
            2 => 'email',
            4 => 'isVerified',
            5 => 'createdAt',
        ];
    }

    public function getById(int $id): User
    {
        return $this->repository->findOneBy([
            'id' => $id
        ]);
    }

    public function convertUserToAuthorDto(User $user): AuthorDto
    {
        $authorDto = new AuthorDto();
        $authorDto->id = $user->getId();
        $authorDto->email = $user->getEmail();
        $authorDto->firstName = $user->getFirstName();
        $authorDto->lastName = $user->getLastName();
        $authorDto->createdAt = $user->getCreatedAt();
        return $authorDto;
    }

    public function convertAllUsersToAuthorDto(array $users): array
    {
        return array_map(
            fn($user): AuthorDto => $this->convertUserToAuthorDto($user),
            $users->toArray()
        );
    }
}
