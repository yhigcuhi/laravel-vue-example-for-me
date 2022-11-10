<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\TaskRepositoryInterface;
use App\Repositories\TaskRepository;

/**
 * リポジトリ系のインターフェイス注入よう
 */
class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //　リポジトリ系の依存注入
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
