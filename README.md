# laravel-recaptcha

Laravel package for Google's reCAPTCHA service

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

This packages adds macros to the form builder service which allows you to easily create reCAPTCHA widgets using the `Form` facade:

    {!! Form::recaptchaScript() !!}
    {!! Form::recaptchaWidget() !!}

    <!-- Output: -->

    <script src="https://www.google.com/recaptcha/api.js"></script>
    <div class="g-recaptcha" data-sitekey="my-site-key"></div>

You can also pass options to the the `recaptchaWidget` function:

    {!! Form::recaptchaWidget(['theme' => 'dark']) !!}

See [reCAPTCHA's documentation](https://developers.google.com/recaptcha/docs/display#render_param) for a full list of available options.

### Validating reCAPTCHA responses

This package also adds a `recaptcha` validation method, for use with Laravel's validation service:

    // in a controller...
    $this->validate($request, [
        'g-recaptcha-response' => 'required|recaptcha'
    ]);

Or, you can access the service directly to do manual validation:

    $recaptcha = app('recaptcha_verifier');

    if ($recaptcha->verify($request->input('g-recaptcha-response'))) {
        // user passed reCAPTCHA
    }
    else {
        // user failed reCAPTCHA
    }




