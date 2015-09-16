<?php

namespace Noylecorp\Recaptcha;

use Collective\Html\HtmlBuilder;

class RecaptchaBuilder
{
    protected $html;
    
    public function __construct(HtmlBuilder $html)
    {
        $this->html = $html;
    }
    
    public function render($sitekey, array $options = [])
    {
        if (!isset($options['sitekey'])) {
            $options['sitekey'] = $sitekey;
        }
        
        $options = $this->renameOptions($options);
        
        return '<div class="g-recaptcha"'.$this->html->attributes($options).'></div>';
    }
    
    public function renameOptions(array $options)
    {
        $renamed = [];
        
        foreach($options as $k => $v) {
            $renamed['data-'.$k] = $v;
        }
        
        return $renamed;
    }
}
