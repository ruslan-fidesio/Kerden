<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Lang;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('not_contains', function($attribute, $value, $parameters){
            // Banned words
            
            $words = Lang::get('bannedWords');
            foreach ($words as $word)
            {
                $regex = '/^'.$word.'[^a-z]|^'.$word.'s[^a-z]|[^a-z]+'.$word.'[^a-z]|[^a-z]+'.$word.'s[^a-z]|[^a-z]'.$word.'$|[^a-z]'.$word.'s$/i';
                if( preg_match($regex, $value) || $value==$word || $value==$word.'s' ) return false;
                //if (stripos($value, $word) !== false) return false;
            }
            return true;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
