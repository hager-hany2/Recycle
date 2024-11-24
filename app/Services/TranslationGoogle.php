<?php

namespace App\Services;
use Stichoza\GoogleTranslate\GoogleTranslate;
class TranslationGoogle
{
    protected $translator;
    public function __construct($lang = 'en')// default $lang=en
    {
        // create object and translate in function
        //Setting up object and translator storage in GoogleTranslate()
        $this->translator = new GoogleTranslate();
        $this->translator->setTarget($lang);
        // To set the language ar or en
    }
    public function translate($text)
    {
        // Retranslate the text with use object GoogleTranslate
        return $this->translator->translate($text);
    }

}
