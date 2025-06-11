<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;

abstract class AbstractService
{
    protected $repository;

    protected $dataTableColumns;

    public function paginateDataTable(Request $request, $cb): array
    {
        $paginatorResult = $this->repository->paginate(
            $request->request->getInt('start', 0),
            $request->request->getInt('length', 10),
            $request->request->all('search')['value'] ?? null,
            $this->dataTableColumns,
            $request->request->all('order')[0] ?? null,
        );

        return [
            'recordsTotal' => $this->repository->count(),
            'recordsFiltered' => $paginatorResult->count(),
            'data' => array_map($cb, $paginatorResult->getQuery()->getResult())
        ];
    }

    public function getAll()
    {
        $this->repository->findAll();
    }
}
