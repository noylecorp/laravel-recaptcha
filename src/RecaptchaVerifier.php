<?php

namespace Noylecorp\Recaptcha;

class RecaptchaVerifier
{
    protected $secretKey;

    public function __construct($secretKey)
    {
        $this->secretKey = $secretKey;
    }

    public function verify($response)
    {
        $payload = [
            'secret' => $this->secretKey,
            'response' => $response
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
        curl_setopt($ch, CURLOPT_POST, count($payload));
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));

        $result = json_decode(curl_exec($ch));

        curl_close($ch);

        return $result->success;
    }
}
