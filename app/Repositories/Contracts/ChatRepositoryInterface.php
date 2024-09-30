<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Chat;
use Illuminate\Support\Collection;
use stdClass;

interface ChatRepositoryInterface
{
    public function findOrFail(int $id): Chat;

    public function getAll(): Collection;

    public function getChatMembersByChatId(int $id): Collection;

    public function getChatById(int $id): stdClass;
}
