<?php

namespace App\Service\Article;

use Symfony\Component\HttpFoundation\Request;

interface ArticleServiceInterface
{
    public function paginateDataTable(Request $request, $cb): array;
}
