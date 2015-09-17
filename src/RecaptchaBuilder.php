<?php

namespace Noylecorp\Recaptcha;

use Collective\Html\HtmlBuilder;

class RecaptchaBuilder
{
    protected $html;

    protected $siteKey;

    protected $tagAttributes = ['sitekey', 'theme', 'type', 'size', 'tabindex', 'callback', 'expired-callback'];

    public function __construct($siteKey, HtmlBuilder $html)
    {
        $this->html = $html;
        $this->siteKey = $siteKey;
    }

    public function widget(array $options = [])
    {
        $options['sitekey'] = $this->siteKey;

        $options['class'] = 'g-recaptcha';

        $this->renameOptions($options);

        return '<div'.$this->html->attributes($options).'></div>'.PHP_EOL;
    }

    public function recaptcha(array $options = [])
    {
        return $this->script().$this->widget($options);
    }

    public function script()
    {
        return $this->html->script('https://www.google.com/recaptcha/api.js');
    }

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
