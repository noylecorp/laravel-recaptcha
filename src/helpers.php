<?php

if (! function_exists('recaptcha')) {
    function recaptcha(array $options = [])
    {
        return app('recaptcha_builder')->recaptcha($options);
    }
}

if (! function_exists('recaptcha_script')) {
    function recaptcha_script()
    {
        return app('recaptcha_builder')->script();
    }
}

if (! function_exists('recaptcha_widget')) {
    function recaptcha_widget(array $options = [])
    {
        return app('recaptcha_builder')->widget($options);
    }
}