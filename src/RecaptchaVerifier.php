<?php

namespace Noylecorp\Recaptcha;

class RecaptchaVerifier
{
    /**
     * The reCAPTCHA secret key
     *
     * @var string
     */
    protected $secretKey;

    /**
     * Create a new reCAPTCHA verifier instance.
     *
     * @param  string                           $secretKey
     * @param  \Collective\Html\HtmlBuilder     $html
     *
     * @return void
     */
    public function __construct($secretKey)
    {
        $this->secretKey = $secretKey;
    }

    /**
     * Verify a reCAPTCHA response
     *
     * @param  string                           $response
     *
     * @return bool
     */
    public function verify($response, $remoteip = null)
    {
        $payload = [
            'secret' => $this->secretKey,
            'response' => $response
        ];

        if ($remoteip) {
            $payload['remoteip'] = $remoteip;
        }

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
