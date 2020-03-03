<?php

namespace App\Providers;

use App\Observers\PostObserver;
use App\Post;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\Resource;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        DB::listen(function ($query) {
            $sql = array_reduce($query->bindings, function($sql, $binding){
                if($binding instanceof \DateTime)
                {
                    $binding = Carbon::instance($binding);
                }
                return preg_replace('/\?/', is_numeric($binding) ? $binding : "'".$binding."'" , $sql, 1);
            }, $query->sql);
            Log::info($sql);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Resource::withoutWrapping();

        Post::observe(PostObserver::class);
    }
}
