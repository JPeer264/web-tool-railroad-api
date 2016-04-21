<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Response;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('mailer', function ($app) {
            $app->configure('services');
            return $app->loadComponent('mail', 'Illuminate\Mail\MailServiceProvider', 'mailer');
        });

        /** @var \Illuminate\Http\Request $request */
        $request = $this->app->make('request');
            if($request->isMethod('OPTIONS')) {
            $this->app->options($request->path(), function(){
                return response('OK', 200);
            });
        }
    }
}
