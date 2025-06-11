<?php

namespace App\Service\User;

use App\Dto\AuthorDto;
use App\Entity\User;
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
     * Get User By Id
     * @param int $id
     * @return \App\Entity\User
     */
    public function getById(int $id): User;

    /**
     * Convert User To Author
     * @param \App\Entity\User $user
     * @return \App\Dto\AuthorDto
     */
    public function convertUserToAuthorDto(User $user): AuthorDto;
}
