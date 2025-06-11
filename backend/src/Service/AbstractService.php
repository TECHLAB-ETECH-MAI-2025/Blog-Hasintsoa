<?php

namespace App\Service;

use App\Dto\PaginationDto;
use Doctrine\ORM\Persisters\Exception\UnrecognizedField;
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

    public function paginateWithPaginationDto(PaginationDto $paginationDto): array
    {
        $data = [];

        $orderBy = [];
        if (isset($paginationDto->orderColumn) && isset($paginationDto->orderDir))
            $orderBy[$paginationDto->orderColumn] = $paginationDto->orderDir;

        try {
            $data['rows'] = $this->repository->findBy(
                [],
                $orderBy,
                $paginationDto->size,
                $paginationDto->size * ($paginationDto->page - 1)
            );
            $data['message'] = 'All Paginated Data';
        } catch (UnrecognizedField $e) {
            $data['rows'] = $this->repository->findBy(
                [],
                [],
                $paginationDto->size,
                $paginationDto->size * ($paginationDto->page - 1)
            );
            $data['message'] = $e->getMessage();
        }

        $count = $this->repository->count([]);

        return [
            ...$data,
            'page' => [
                'size' => $paginationDto->size,
                'totalElements' => $count,
                'currentPage' => $paginationDto->page,
                'totalPages' => ceil($count / $paginationDto->size)
            ]
        ];
    }

    /**
     * Get All Entity Table
     * @return array
     */
    public function getAll(): array
    {
        return $this->repository->findAll();
    }
}
