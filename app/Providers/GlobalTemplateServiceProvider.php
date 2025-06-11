<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\Projects;

class GlobalTemplateServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(['layouts.app','layouts.app1','dashboard'], function ($view) {
            $view->with('userProjects', $this->getProjects());
        });
    }

    public function getProjects(){
        return Projects::all()->where("user_id", Auth::id())->sortByDesc("id");
    }
}
