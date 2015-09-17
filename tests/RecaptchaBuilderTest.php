<?php

use Collective\Html\HtmlBuilder;
use Illuminate\Http\Request;
use Illuminate\Routing\RouteCollection;
use Illuminate\Routing\UrlGenerator;

use Noylecorp\Recaptcha\RecaptchaBuilder;

class RecaptchaBuilderTest extends PHPUnit_Framework_TestCase
{
    /**
     * Setup the test environment.
     */
    public function setUp()
    {
        $this->urlGenerator = new UrlGenerator(new RouteCollection(), Request::create('/foo', 'GET'));
        $this->htmlBuilder = new HtmlBuilder($this->urlGenerator);
        $this->siteKey = 'my-site-key';
        $this->recaptchaBuilder = new RecaptchaBuilder($this->siteKey, $this->htmlBuilder);
    }

    public function testWidget()
    {
        $r1 = $this->recaptchaBuilder->widget();
        $r2 = $this->recaptchaBuilder->widget(['theme' => 'dark']);
        $r3 = $this->recaptchaBuilder->widget(['type' => 'audio']);

        $this->assertEquals('<div class="g-recaptcha" data-sitekey="my-site-key"></div>'.PHP_EOL, $r1);
        $this->assertEquals('<div class="g-recaptcha" data-theme="dark" data-sitekey="my-site-key"></div>'.PHP_EOL, $r2);
        $this->assertEquals('<div class="g-recaptcha" data-type="audio" data-sitekey="my-site-key"></div>'.PHP_EOL, $r3);
    }

    public function testRecaptcha()
    {
        $r = $this->recaptchaBuilder->recaptcha();
        $this->assertEquals('<script src="https://www.google.com/recaptcha/api.js"></script>'.PHP_EOL.'<div class="g-recaptcha" data-sitekey="my-site-key"></div>'.PHP_EOL, $r);
    }

    public function testScript()
    {
        $script = $this->recaptchaBuilder->script();
        $this->assertEquals('<script src="https://www.google.com/recaptcha/api.js"></script>'.PHP_EOL, $script);
    }
}
