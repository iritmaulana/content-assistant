<?php

namespace App\Services;

use App\Interfaces\LLMProviderInterface;
use App\Services\LLM\DeepseekProvider;
use App\Services\LLM\OpenAIProvider;
use App\Services\LLM\AnthropicProvider;

class LLMFactory
{
    public static function make(string $provider): LLMProviderInterface
    {
        return match ($provider) {
            'deepseek' => new DeepseekProvider(),
            'openai' => new OpenAIProvider(),
            'anthropic' => new AnthropicProvider(),
            default => throw new \InvalidArgumentException("Unsupported LLM provider: {$provider}")
        };
    }
}
