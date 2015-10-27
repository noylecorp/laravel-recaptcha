<?php

namespace Noylecorp\Recaptcha;

use Collective\Html\HtmlBuilder;
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

        if ($this->app->bound('form')) {
            $this->registerMacros();
        }

        $this->app['validator']->extend('recaptcha', function ($attribute, $value, $parameters) {
            return app('recaptcha')->verify($value, app('request')->ip());
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('recaptcha_builder', function ($app) {
            if ($this->app->bound('html')) {
                $html = $app['html'];
            } else {
                $html = new HtmlBuilder($app['url']);
            }

            return new RecaptchaBuilder($app['config']['recaptcha.site_key'], $html);
        });

        $this->app->singleton('recaptcha', function ($app) {
            return new RecaptchaVerifier($app['config']['recaptcha.secret_key']);
        });
    }

    /**
     * Add macros to the form service
     *
     * @return void
     */
    protected function registerMacros()
    {
        $this->app['form']->macro('recaptcha', function () {
            return recaptcha();
        });

        $this->app['form']->macro('recaptcha_noscript', function () {
            return recaptcha_noscript();
        });

        $this->app['form']->macro('recaptcha_script', function () {
            return recaptcha_script();
        });

        $this->app['form']->macro('recaptcha_widget', function (array $options = []) {
            return recaptcha_widget($options);
        });
    }
}
