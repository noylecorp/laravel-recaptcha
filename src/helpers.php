<?php

if (! function_exists('recaptcha')) {
    function recaptcha(array $options = [])
    {
        return app('recaptcha_builder')->recaptcha($options);
    }
}

if (! function_exists('recaptcha_noscript')) {
    function recaptcha_noscript()
    {
        return app('recaptcha_builder')->noscript();
    }
}

if (! function_exists('recaptcha_script')) {
    function recaptcha_script()
    {
        return app('recaptcha_builder')->script();
    }
}

if (! function_exists('recaptcha_site_key')) {
    function recaptcha_site_key()
    {
        return app('config')['recaptcha.site_key'];
    }
}

if (! function_exists('recaptcha_widget')) {
    function recaptcha_widget(array $options = [])
    {
        return app('recaptcha_builder')->widget($options);
    }
}