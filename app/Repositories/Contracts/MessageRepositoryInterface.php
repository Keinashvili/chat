<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Pagination\CursorPaginator;

interface MessageRepositoryInterface
{
    public function findById(int $id);

    public function getAllByChatId(int $id): CursorPaginator;
}
