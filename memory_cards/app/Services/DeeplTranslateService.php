<?php

namespace App\Services;

use App\Services\Contracts\TranslatorInterface;
use DeepL\Translator;


class DeeplTranslateService implements TranslatorInterface
{
    private Translator $translator;

    public function __construct()
    {
        $auth_key = env('TRANSLATE_API_KEY');
        $this->translator = new Translator($auth_key);

    }

    public function translate(string $text, string $from, string $to): string
    {
        $to = $this->getTargetLanguage($to);
        $translate = $this->translator->translateText($text, $from, $to);
        return mb_strtolower($translate->text);
    }

    /**
     * @inheritDoc
     */
    public function getAccessLangs(): array
    {
        $access_langs = [];
        $source_languages = $this->translator->getSourceLanguages();
        foreach ($source_languages as $source_language) {
            $access_langs[] = [
                'loc' => $source_language->code,
                'name' => $source_language->name,
            ];
        }

        return $access_langs;
    }

    public function checkAccessTranslate(): bool
    {
        return !$this->translator->getUsage()->anyLimitReached();
    }

    private function getTargetLanguage(string $code)
    {
        return match ($code) {
            'EN' => 'EN-GB',
            'PT' => 'PT-PT',
            'ZH' => 'ZH-HANT',
            default => $code,
        };
    }
}
