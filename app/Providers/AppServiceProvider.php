<?php

namespace App\Providers;

use App\Interfaces\Author\AuthorRepositoryInterface;
use App\Interfaces\Email\EmailServiceInterface;
use App\Interfaces\User\UserRepositoryInterface;
use App\Repositories\Author\AuthorRepository;
use App\Repositories\User\UserRepository;
use App\Services\Email\EmailService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(EmailServiceInterface::class, EmailService::class);
        $this->app->bind(AuthorRepositoryInterface::class, AuthorRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
