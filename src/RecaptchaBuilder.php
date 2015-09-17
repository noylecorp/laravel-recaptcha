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
        }
        else {
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
     * Create <script> tag for a reCAPTCHA widget
     *
     * @param  array $options
     *
     * @return string
     */
    public function script()
    {
        return $this->html->script('https://www.google.com/recaptcha/api.js');
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
        foreach($options as $k => $v) {
            if (in_array($k, $this->tagAttributes)) {
                $options['data-'.$k] = $v;
                unset($options[$k]);
            }
        }
    }
}
