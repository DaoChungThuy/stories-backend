<?php

namespace App\Providers;

use App\Interfaces\Author\AuthorRepositoryInterface;
use App\Interfaces\Book\BookRepositoryInterface;
use App\Interfaces\Email\EmailServiceInterface;
use App\Interfaces\ServicePackage\ServicePackageRepositoryInterface;
use App\Interfaces\User\UserRepositoryInterface;
use App\Interfaces\UserServicePackage\UserServicePackageRepositoryInterFace;
use App\Repositories\Author\AuthorRepository;
use App\Repositories\Book\BookRepository;
use App\Repositories\ServicePackage\ServicePackageRepository;
use App\Repositories\User\UserRepository;
use App\Repositories\UserServicePackage\UserServicePackageRepository;
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
        $this->app->bind(BookRepositoryInterface::class, BookRepository::class);
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
