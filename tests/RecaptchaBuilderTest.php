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
        $r  = $this->recaptchaBuilder->widget();
        $r1 = $this->recaptchaBuilder->widget(['id' => 'myrecaptcha']);
        $r2 = $this->recaptchaBuilder->widget(['theme' => 'dark']);
        $r3 = $this->recaptchaBuilder->widget(['type' => 'audio']);
        $r4 = $this->recaptchaBuilder->widget(['data-type' => 'audio']);
        $r5 = $this->recaptchaBuilder->widget(['class' => 'my-class']);

        // RecaptchaBuilder outputs attributes in predictable but less than
        // intuitive order, so these tests are brittle
        $this->assertEquals('<div class="g-recaptcha" data-sitekey="my-site-key"></div>'.PHP_EOL, $r);
        $this->assertEquals('<div id="myrecaptcha" class="g-recaptcha" data-sitekey="my-site-key"></div>'.PHP_EOL, $r1);
        $this->assertEquals('<div class="g-recaptcha" data-theme="dark" data-sitekey="my-site-key"></div>'.PHP_EOL, $r2);
        $this->assertEquals('<div class="g-recaptcha" data-type="audio" data-sitekey="my-site-key"></div>'.PHP_EOL, $r3);
        $this->assertEquals('<div data-type="audio" class="g-recaptcha" data-sitekey="my-site-key"></div>'.PHP_EOL, $r4);
        $this->assertEquals('<div class="my-class g-recaptcha" data-sitekey="my-site-key"></div>'.PHP_EOL, $r5);
    }

    public function testRecaptcha()
    {
        $r = $this->recaptchaBuilder->recaptcha();
        $r1 = $this->recaptchaBuilder->recaptcha(['theme' => 'dark']);

        $this->assertEquals('<script src="https://www.google.com/recaptcha/api.js"></script>'.PHP_EOL.'<div class="g-recaptcha" data-sitekey="my-site-key"></div>'.PHP_EOL, $r);
        $this->assertEquals('<script src="https://www.google.com/recaptcha/api.js"></script>'.PHP_EOL.'<div class="g-recaptcha" data-theme="dark" data-sitekey="my-site-key"></div>'.PHP_EOL, $r1);
    }

    public function testNoScript()
    {
        $noscript = $this->recaptchaBuilder->noscript();
        $this->assertEquals('<noscript><iframe src="https://www.google.com/recaptcha/api/fallback?k=my-site-key" frameborder="0" scrolling="no" style="width: 302px; height:422px; border-style: none; display: block;"></iframe><textarea id="g-recaptcha-response" name="g-recaptcha-response" class="g-recaptcha-response" style="width: 302px; height: 40px;"></textarea><noscript>'.PHP_EOL, $noscript);
    }

    public function testScript()
    {
        $script = $this->recaptchaBuilder->script();
        $this->assertEquals('<script src="https://www.google.com/recaptcha/api.js"></script>'.PHP_EOL, $script);
    }
}
