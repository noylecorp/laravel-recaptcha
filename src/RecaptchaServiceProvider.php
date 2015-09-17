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

        $this->registerMacros();

        $this->app['validator']->extend('recaptcha', function ($attribute, $value, $parameters) {
            return app('recaptcha_verifier')->verify($value);
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

        $this->app->singleton('recaptcha_verifier', function($app) {
            return new RecaptchaVerifier($app['config']['recaptcha.site_secret']);
        });
    }

    protected function registerMacros()
    {
        $this->app['form']->macro('recaptcha', function() {
            return app('recaptcha_builder')->recaptcha();
        });

        $this->app['form']->macro('recaptcha_script', function() {
            return app('recaptcha_builder')->script();
        });

        $this->app['form']->macro('recaptcha_widget', function(array $options = []) {
            return app('recaptcha_builder')->widget($options);
        });
    }
}
