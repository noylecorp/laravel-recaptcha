<?php

use Collective\Html\HtmlBuilder;
use Noylecorp\Recaptcha\RecaptchaBuilder;

class RecaptchaBuilderTest extends PHPUnit_Framework_TestCase
{
    public function testRender()
    {
        $html = new HtmlBuilder;
        $recaptcha = new RecaptchaBuilder($html);

        $r1 = $recaptcha->render('my-site-key');

        print $r1;exit;
    }
}
