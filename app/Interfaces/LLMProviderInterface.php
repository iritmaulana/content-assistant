<?php

namespace App\Interfaces;

interface LLMProviderInterface
{
    public function generateContent(string $prompt, array $options = []): array;
}
