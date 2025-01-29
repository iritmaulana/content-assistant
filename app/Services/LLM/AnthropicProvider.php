<?php

namespace App\Services\LLM;

use App\Interfaces\LLMProviderInterface;
use Illuminate\Support\Facades\Http;

class AnthropicProvider implements LLMProviderInterface
{
    public function generateContent(string $prompt, array $options = []): array
    {
        try {
            $response = Http::withHeaders([
                'x-api-key' => config('services.anthropic.api_key'),
                'Content-Type' => 'application/json',
            ])->post('https://api.anthropic.com/v1/messages', [
                'model' => $options['model'] ?? 'claude-3-opus-20240229',
                'max_tokens' => $options['max_tokens'] ?? 1000,
                'messages' => [
                    ['role' => 'user', 'content' => $prompt]
                ]
            ]);

            return [
                'success' => true,
                'content' => $response->json()['content'][0]['text'] ?? '',
                'provider' => 'anthropic'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'Anthropic API error: ' . $e->getMessage(),
                'provider' => 'anthropic'
            ];
        }
    }
}
