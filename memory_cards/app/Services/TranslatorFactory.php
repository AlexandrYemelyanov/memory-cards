<?php

namespace App\Services;

use App\Services\Contracts\TranslatorInterface;

class TranslatorFactory
{
    protected array $translators;

    public function __construct()
    {
        $this->translators = [
            'deepl' => DeeplTranslateService::class,
        ];
    }

    public function make(string $service = ''): TranslatorInterface
    {
        if (empty($service)) {
            $service = env('TRANSLATE_SERVICE', 'deepl');
        }
        if (!isset($this->translators[$service])) {
            throw new \InvalidArgumentException("The $service is not supported.");
        }

        return app($this->translators[$service]);
    }
}
