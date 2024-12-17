<?php

namespace App\Services;

use Stichoza\GoogleTranslate\GoogleTranslate;

class TranslationGoogle
{
    protected $translator;

    public function __construct($lang = 'en') // Default target language is 'en'
    {
        try {
            $this->translator = new GoogleTranslate();
            $this->translator->setTarget($lang);
        } catch (\Exception $e) {
            throw new \RuntimeException('Error initializing translator: ' . $e->getMessage());
        }
    }

    public function translate($text)
    {
        try {
            // Convert input to string (handles null or other types)
            $text = (string) $text;

            // Ensure text is not empty after conversion
            if (trim($text) === '') {
                throw new \InvalidArgumentException('The input text cannot be an empty string.');
            }

            return $this->translator->translate($text);
        } catch (\InvalidArgumentException $e) {
            // Handle invalid input error
            return 'Input Error: ' . $e->getMessage();
        } catch (\Exception $e) {
            // Handle other GoogleTranslate errors
            return 'Translation Error: ' . $e->getMessage();
        }
    }
}
