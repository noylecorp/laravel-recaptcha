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
        $this->recaptchaBuilder = new RecaptchaBuilder($this->htmlBuilder);
    }

    public function testRender()
    {
        $r1 = $this->recaptchaBuilder->render('my-site-key');

        $this->assertEquals('<div class="g-recaptcha" data-sitekey="my-site-key"></div>'.PHP_EOL, $r1);
    }

    public function testScript()
    {
        $script = $this->recaptchaBuilder->script();
        $this->assertEquals('<script src="https://www.google.com/recaptcha/api.js"></script>'.PHP_EOL, $script);
    }
}
