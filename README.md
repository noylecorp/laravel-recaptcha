[![Build Status](https://travis-ci.org/noylecorp/laravel-recaptcha.svg)](https://travis-ci.org/noylecorp/laravel-recaptcha)

# laravel-recaptcha

Laravel 5.1 package for Google reCAPTCHA, providing helper functions for creating reCAPTCHA fields and a service for validating responses.

**Note:** This package uses reCAPTCHA API version 2.0

## Installation

`noylecorp/laravel-recaptcha` requires the `laravelcollective/html` package. [Head on over to their site](http://laravelcollective.com/docs/5.1/html) for documentation on getting it installed.

You'll also need to [sign up for a reCAPTCHA key pair](https://www.google.com/recaptcha/admin) in order to finish installation and start using this package.

Once those tasks are completed, install `noylecorp/laravel-recaptcha` with composer:

    composer require noylecorp/laravel-recaptcha dev-master

Next, add the service provider to your `config/app.php`:

    'providers' => [
        // ...
        Noylecorp\Recaptcha\RecaptchaServiceProvider::class,
    ]

Next, publish the package configuration file to your application:

    php artisan vendor:publish --provider="Noylecorp\Recaptcha\RecaptchaServiceProvider"

The file `recaptcha.php` gets copied into your configuration directory. The final installation step is to add your reCAPTCHA site and secret keys to your `.env` file:

    RECAPTCHA_SITE_KEY=your-site-key
    RECAPTCHA_SECRET_KEY=your-secret-key

## Usage

### Creating a reCAPTCHA widget

You can easily create reCAPTCHA widgets using the `recaptcha()` helper function:

    {!! recaptcha() !!}

    // outputs...

    <script src="https://www.google.com/recaptcha/api.js"></script>
    <div class="g-recaptcha" data-sitekey="my-site-key"></div>

You can also pass in HTML attributes:

    {!! recaptcha(['id' => 'myrecaptcha']) !!}

Or any of [reCAPTCHA's available options](https://developers.google.com/recaptcha/docs/display#render_param):

    {!! recaptcha(['theme' => 'dark']) !!}

    {!! recaptcha(['data-theme' => 'dark']) !!} // same thing

If you need to render the `<script>` and `<div>` tags for the reCAPTCHA widget separately, you can use the `recaptch_script()` and `recaptcha_widget()` functions:

    {!! recaptcha_script() !!}

    // ...

    {!! recaptcha_widget() !!}

All three functions, `recaptcha()`, `recaptcha_script()`, and `recaptcha_widget()`, can also be accessed through the `Form` facade:

    {!! Form::recaptcha() !!}

### Validating reCAPTCHA responses

The simplest way to validate a reCAPTCHA field is by using the added `recaptcha` validation rule:

    // in a controller...
    $this->validate($request, [
        'g-recaptcha-response' => 'required|recaptcha'
    ]);

    // in a form request...
    public function rules()
    {
        return [
            'g-recaptcha-response' => 'required|recaptcha'
        ];
    }

Or, you can access the service directly to do manual validation:

    if (app('recaptcha')->verify($request->input('g-recaptcha-response'))) {
        // user passed reCAPTCHA
    }
    else {
        // user failed reCAPTCHA
    }
