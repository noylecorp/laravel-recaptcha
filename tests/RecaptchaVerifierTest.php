<?php

use Noylecorp\Recaptcha\RecaptchaVerifier;

class RecaptchaVerifierTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        // See: https://developers.google.com/recaptcha/docs/faq?hl=en
        $this->siteKey = '6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI';
        $this->secretKey = '6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe';
        $this->apiFallback='https://www.google.com/recaptcha/api/fallback?k='.$this->siteKey;

        $this->verifier = new RecaptchaVerifier($this->secretKey);
    }

    public function testVerify()
    {
        $result = $this->verifier->verify($this->getGCatpchaResponse());
        $this->assertTrue($result);
    }

    protected function getGCatpchaResponse()
    {
        $captchaForm = new DOMDocument();
        $captchaForm->loadHTMLFile($this->apiFallback);

        $payload = [];

        foreach ($captchaForm->getElementsByTagName('input') as $input) {
            if ('c' == $input->getAttribute('name')) {
                $payload['c'] = $input->getAttribute('value');
                break;
            }
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $this->apiFallback);
        curl_setopt($ch, CURLOPT_POST, count($payload));
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));

        $result = curl_exec($ch);

        $captchaResponse = new DOMDocument();
        $captchaResponse->loadHTML($result);

        foreach ($captchaResponse->getElementsByTagName('textarea') as $textarea) {
            return $textarea->nodeValue;
        }
    }
}
