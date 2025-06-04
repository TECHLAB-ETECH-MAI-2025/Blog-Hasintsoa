<?php

namespace App\Service\User;

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
}
