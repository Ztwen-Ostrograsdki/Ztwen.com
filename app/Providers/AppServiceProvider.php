<?php

namespace App\Providers;

use App\Models\FollowingSystem;
use App\Models\UserOnlineSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('isAdmin', function($user = null){
            if(Auth::user()){
                if($user == null){
                    $user = Auth::user();
                }
                if($user->role == 'admin' || $user->id == 1){
                    return true;
                }
                return false;
            }
            return false;

        });

        Blade::if('isNotAdmin', function($user = null){
            if($user == null){
                $user = Auth::user();
            }
            if($user->role == 'admin' || $user->id == 1){
                return false;
            }
            return true;
        });

        Blade::if('isNotMaster', function($user = null){
            if($user == null){
                $user = Auth::user();
            }
            if($user->id == 1){
                return false;
            }
            return true;

        });
        Blade::if('isMaster', function($user = null){
            if($user == null){
                $user = Auth::user();
            }
            if($user->id == 1){
                return true;
            }
            return false;

        });


        Blade::if('isMySelf', function($user){
            if($user->id == Auth::user()->id){
                return true;
            }
            return false;

        });

        Blade::if('fixedHeaderForRoute', function(){
            $route = Route::currentRouteName();
            $routesNames = config('app.routes');
            if(in_array($route, $routesNames)){
                return true;
            }
            return false;

        });
        Blade::if('isRoute', function($routeName){
            if(Route::currentRouteName() == $routeName){
                return true;
            }
            return false;

        });

        Blade::if('isNotRoute', function($routeName){
            if(Route::currentRouteName() == $routeName){
                return false;
            }
            return true;

        });


        Blade::if('isOnline', function($user){
            $online = UserOnlineSession::where('user_id', $user->id)->first();
            if($online){
                return true;
            }
            return false;

        });

        Blade::if('isNotOnline', function($user){
            $online = UserOnlineSession::where('user_id', $user->id)->first();
            if(!$online){
                return true;
            }
            return false;

        });

        Blade::if('isMyFriend', function($user){
            if(Auth::user()->isMyFriend($user)){
                return true;
            }
            return false;

        });




    }
}