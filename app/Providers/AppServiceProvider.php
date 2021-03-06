<?php

namespace App\Providers;

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
        $this->app->bind('App\Contracts\Dao\Category\CategoryDaoInterface', 'App\Dao\Category\CategoryDao');
        $this->app->bind('App\Contracts\Services\Category\CategoryServiceInterface', 'App\Services\Category\CategoryService');
        $this->app->bind('App\Contracts\Dao\User\UserDaoInterface','App\Dao\User\UserDao');
        $this->app->bind('App\Contracts\Services\User\UserServiceInterface','App\Services\User\UserService');
        $this->app->bind('App\Contracts\Dao\Course\CourseDaoInterface','App\Dao\Course\CourseDao');
        $this->app->bind('App\Contracts\Services\Course\CourseServiceInterface','App\Services\Course\CourseService');
        $this->app->bind('App\Contracts\Dao\CourseVideo\CourseVideoDaoInterface','App\Dao\CourseVideo\CourseVideoDao');
        $this->app->bind('App\Contracts\Dao\Comment\CommentDaoInterface','App\Dao\Comment\CommentDao');
        $this->app->bind('App\Contracts\Services\Comment\CommentServiceInterface','App\Services\Comment\CommentService');
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
