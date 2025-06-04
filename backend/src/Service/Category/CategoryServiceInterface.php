<?php

namespace App\Service\Category;

use Symfony\Component\HttpFoundation\Request;

interface CategoryServiceInterface
{
    public function paginateDataTable(Request $request, $cb): array;
}
