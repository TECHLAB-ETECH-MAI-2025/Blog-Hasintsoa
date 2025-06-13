<?php

namespace App\Service\User;

use App\Dto\AuthorDto;
use App\Dto\PaginationDto;
use App\Entity\User;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\Request;

interface UserServiceInterface
{
    /**
     * Paginate User for Datatable
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param mixed $cb
     * @return array
     */
    public function paginateDataTable(Request $request, $cb): array;

    /**
     * Paginate Users with PaginationDto
     * @param PaginationDto $paginationDto
     * @return User[]
     */
    public function paginateWithPaginationDto(PaginationDto $paginationDto): array;

    /**
     * Get User By Id
     * @param int $id
     * @return User
     */
    public function getById(int $id): User;

    /**
     * Convert User To Author
     * @param User $user
     * @return AuthorDto
     */
    public function convertUserToAuthorDto(User $user): AuthorDto;

    /**
     * Convert all users to AuthorDto
     * @param Collection<int, User> $users
     * @return AuthorDto[]
     */
    public function convertAllUsersToAuthorDto(array $users): array;
}
