<?php

namespace Noylecorp\Recaptcha;

use Illuminate\Support\ServiceProvider;

class RecaptchaServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/recaptcha.php' => config_path('recaptcha.php'),
        ]);

        $this->addMacros();

        $this->app['validator']->extend('recaptcha', function ($attribute, $value, $parameters) {
            return app('recaptcha')->verify($value);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('recaptcha_builder', function($app) {
            return new RecaptchaBuilder($app['config']['recaptcha.site_key'], $app['html']);
        });

        $this->app->singleton('recaptcha', function($app) {
            return new RecaptchaVerifier($app['config']['recaptcha.secret_key']);
        });
    }

    /**
     * Add macros to the form service
     *
     * @return void
     */
    protected function addMacros()
    {
        $this->app['form']->macro('recaptcha', function() {
            return recaptcha();
        });

        $this->app['form']->macro('recaptcha_script', function() {
            return recaptcha_script();
        });

        $this->app['form']->macro('recaptcha_widget', function(array $options = []) {
            return recaptcha_widget($options);
        });
    }
}
