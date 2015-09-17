[![Build Status](https://travis-ci.org/noylecorp/laravel-recaptcha.svg)](https://travis-ci.org/noylecorp/laravel-recaptcha)

# laravel-recaptcha

Laravel package for Google reCAPTCHA, providing helper functions for creating reCAPTCHA fields and a service for validating responses.

## Installation

`noylecorp/laravel-recaptcha` requires the `laravelcollective/html` package. [Head on over to their site](http://laravelcollective.com/docs/5.1/html) for documentation on getting it installed.

Once that's completed, you can begin by installing `noylecorp/laravel-recaptcha` with composer:

    composer require noylecorp/laravel-recaptcha dev-master

Next, add the service provider to your `config/app.php`:

    'providers' => [
        // ...
        Noylecorp\Recaptcha\RecaptchaServiceProvider::class,
    ]

Next, publish the package's configuration files to your application:

    php artisan vendor:publish

Finally, update `.env` with your reCAPTCHA site key and secret:

    RECAPTCHA_SITE_KEY=your-site-key
    RECAPTCHA_SITE_SECRET=your-site-secret

## Usage

### Creating a reCAPTCHA widget

You can easily create reCAPTCHA widgets using the `recaptcha()` helper function:

    {!! recaptcha() !!}

    <!-- Output: -->

    <script src="https://www.google.com/recaptcha/api.js"></script>
    <div class="g-recaptcha" data-sitekey="my-site-key"></div>

You can also pass options to `recaptcha()`:

    {!! recaptcha(['theme' => 'dark']) !!}

See [reCAPTCHA's documentation](https://developers.google.com/recaptcha/docs/display#render_param) for a full list of available options.

The `recaptcha()` function returns both the `<script>` and `<div>` tags necessary to to build a reCAPTCHA field. If you need more flexibility, it's also possible to insert those fields separately using the `recaptch_script()` and `recaptcha_widget()` functions:

    {!! recaptcha_script() !!}

    // ...

    {!! recaptcha_widget() !!}

All three functions, `recaptcha()`, `recaptcha_script()`, and `recaptcha_widget()`, can also be accessed through the `Form` facade:

    {!! Form::recaptcha() !!}

### Validating reCAPTCHA responses

The simplest way to validate a reCAPTCHA field is using the added `recaptcha` rule:

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
