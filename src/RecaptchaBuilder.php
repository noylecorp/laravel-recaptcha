<?php

namespace Noylecorp\Recaptcha;

use Collective\Html\HtmlBuilder;

class RecaptchaBuilder
{
    protected $html;

    protected $tagAttributes = ['sitekey', 'theme', 'type', 'size', 'tabindex', 'callback', 'expired-callback'];

    public function __construct(HtmlBuilder $html)
    {
        $this->html = $html;
    }

    public function render($sitekey, array $options = [])
    {
        if (!isset($options['sitekey'])) {
            $options['sitekey'] = $sitekey;
        }

        $options['class'] = 'g-recaptcha';

        $this->renameOptions($options);

        return '<div'.$this->html->attributes($options).'></div>'.PHP_EOL;
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
