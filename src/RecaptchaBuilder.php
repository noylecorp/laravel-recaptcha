<?php

namespace Noylecorp\Recaptcha;

use Collective\Html\HtmlBuilder;

class RecaptchaBuilder
{
    /**
     * The HTML builder instance.
     *
     * @var \Collective\Html\HtmlBuilder
     */
    protected $html;

    /**
     * Url for the JS api
     *
     * @var string
     */
    protected $jsApi = 'https://www.google.com/recaptcha/api.js';

    /**
     * The reCAPTCHA widget class
     *
     * @var string
     */
    protected $recaptchaClass = 'g-recaptcha';

    /**
     * The reCAPTCHA site key
     *
     * @var string
     */
    protected $siteKey;

    /**
     * Tag attributes recognized as configuration options by reCAPTCHA
     *
     * @var array
     */
    protected $tagAttributes = ['sitekey', 'theme', 'type', 'size', 'tabindex', 'callback', 'expired-callback'];

    /**
     * Create a new reCAPTCHA builder instance.
     *
     * @param  string                           $siteKey
     * @param  \Collective\Html\HtmlBuilder     $html
     *
     * @return void
     */
    public function __construct($siteKey, HtmlBuilder $html)
    {
        $this->html = $html;
        $this->siteKey = $siteKey;
    }

    /**
     * Create <div> tag for a reCAPTCHA widget
     *
     * @param  array $options
     *
     * @return string
     */
    public function widget(array $options = [])
    {
        $options['sitekey'] = $this->siteKey;

        if (isset($options['class'])) {
            $options['class'] .= ' '.$this->recaptchaClass;
        } else {
            $options['class'] = $this->recaptchaClass;
        }

        $this->renameOptions($options);

        return '<div'.$this->html->attributes($options).'></div>'.PHP_EOL;
    }

    /**
     * Create <script> and <div> tags for a reCAPTCHA widget
     *
     * @param  array $options
     *
     * @return string
     */
    public function recaptcha(array $options = [])
    {
        return $this->script().$this->widget($options);
    }

    /**
     * Create <noscript> widget
     *
     * @return string
     */
    public function noscript()
    {
        return '<noscript>'
              .'<iframe src="https://www.google.com/recaptcha/api/fallback?k='.$this->siteKey.'" frameborder="0" scrolling="no" style="width: 302px; height:422px; border-style: none; display: block;"></iframe>'
              .'<textarea id="g-recaptcha-response" name="g-recaptcha-response" class="g-recaptcha-response" style="width: 302px; height: 40px;"></textarea>'
              .'</noscript>'.PHP_EOL
        ;
    }

    /**
     * Create <script> tag for a reCAPTCHA widget
     *
     * @param  array $options
     *
     * @return string
     */
    public function script()
    {
        return $this->html->script($this->jsApi);
    }

    /**
     * Rename specified options keys to attribute names recognized by reCAPTCHA
     *
     * @param  array &$options
     *
     * @return string
     */
    public function renameOptions(array &$options)
    {
        foreach ($options as $k => $v) {
            if (in_array($k, $this->tagAttributes)) {
                $options['data-'.$k] = $v;
                unset($options[$k]);
            }
        }
    }
}
