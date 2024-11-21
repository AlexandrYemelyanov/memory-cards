<?php

namespace App\Services\Contracts;

interface TranslatorInterface
{
    /**
     * @return array<array{loc: string, name: string}>
     */
    public function getAccessLangs(): array;
    public function translate(string $text, string $from, string $to): string;
    public function checkAccessTranslate(): bool;
}
