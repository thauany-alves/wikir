<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Http\User;
use App\Models\Post;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $user = auth()->user();

        $ability = 'is_admin';
        Gate::before(function ($user, $ability) {
            if($user->admin == 'S')
            return true;
        });

        Gate::define('is_editor', function ($user) {
            return ($user->admin == 'S' ? true : $user->editor == 'S');
        });

        Gate::define('update_post', function ($user, $post_user_id){
            return ($user->editor == 'S' ? true : $user->id == $post_user_id);
        }); 
    }
}
