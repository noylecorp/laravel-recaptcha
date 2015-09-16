<?php

use Noylecorp\Recaptcha\RecaptchaVerifier;

class RecaptchaVerifierTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        // See: https://developers.google.com/recaptcha/docs/faq?hl=en
        $this->secretKey = '6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe';
        $this->successResponse = '03AHJ_VuvRm7ZPgsy5DKbvbf3aBfXLwG3lHHWftZb1Qvo-tvq8w6UKvIGraLBi0wlbANUJpZLjfAELENnsy30IW1W01UbktlpDcsAJh-ZtYtaNM9g542FUwPWJAEQOeSDqHIiMxdJDPv8OXlxUwUpeDywxvk6qHUOeHb4n3tX_AFGNC1NhSPGCLHBx2kIux4sJjfLUbuXK86ZRbUnbfw8uPSLPdmZs4CubdHEK4FKzQJLoiglZAya1pno7H8K6AbMdaB2rsJ74NUxOQFGG6AFtqXx2OPJq1lCoTaJL5ijCkGVzPpQfRou7ekUfct6iOnoA5uX5ohA5K2w58D3RPtauPEilKuH7X-y-AB0GXxJDcnTxDmN95_7j8GU';

        $this->verifier = new RecaptchaVerifier($this->secretKey);
    }

    public function testVerify()
    {
        $result = $this->verifier->verify($this->successResponse);
        $this->assertTrue($result);
    }
}