<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\ChatRepository;
use App\Repositories\ChatUserRepository;
use App\Repositories\MessageRepository;
use App\Repositories\UserRepository;
use App\Repositories\Contracts\ChatRepositoryInterface;
use App\Repositories\Contracts\ChatUserRepositoryInterface;
use App\Repositories\Contracts\MessageRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(
            ChatRepositoryInterface::class,
            ChatRepository::class,
        );

        $this->app->singleton(
            MessageRepositoryInterface::class,
            MessageRepository::class,
        );

        $this->app->singleton(
            UserRepositoryInterface::class,
            UserRepository::class,
        );

        $this->app->singleton(
            ChatUserRepositoryInterface::class,
            ChatUserRepository::class,
        );
    }

    public function boot(): void
    {
        //
    }
}
