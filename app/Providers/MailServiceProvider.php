<?php

namespace App\Providers;

use Illuminate\Mail\Mailer;

class MailServiceProvider extends \Illuminate\Mail\MailServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function registerIlluminateMailer()
    {
        $this->app->singleton('mailer', function ($app) {
            $config = $app->make('config')->get('mail');

            // Once we have create the mailer instance, we will set a container instance
            // on the mailer. This allows us to resolve mailer classes via containers
            // for maximum testability on said classes instead of passing Closures.
            $mailer = new Mailer(
                $app['view'], $app['swift.mailer'], $app['events']
            );

            // The trick
            $mailer->setQueue($app['queue']);


            return $mailer;
        });
        $this->app->configure('mail');
        // The job cannot be done without it
        $this->app->alias('mailer', \Illuminate\Contracts\Mail\Mailer::class);
    }
}
