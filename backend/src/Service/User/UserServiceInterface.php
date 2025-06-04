<?php

namespace App\Service\User;

use Symfony\Component\HttpFoundation\Request;

interface UserServiceInterface
{
    public function paginateDataTable(Request $request, $cb): array;
}
