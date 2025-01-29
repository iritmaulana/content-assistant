<?php

namespace App\Services\LLM;

use App\Interfaces\LLMProviderInterface;
use Illuminate\Support\Facades\Http;

class OpenAIProvider implements LLMProviderInterface
{
    public function generateContent(string $prompt, array $options = []): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.openai.api_key'),
                'Content-Type' => 'application/json',
            ])->post('https://api.openai.com/v1/completions', [
                'model' => $options['model'] ?? 'gpt-3.5-turbo',
                'prompt' => $prompt,
                'max_tokens' => $options['max_tokens'] ?? 1000,
                'temperature' => $options['temperature'] ?? 0.7,
            ]);

            return [
                'success' => true,
                'content' => $response->json()['choices'][0]['text'] ?? '',
                'provider' => 'openai'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'OpenAI API error: ' . $e->getMessage(),
                'provider' => 'openai'
            ];
        }
    }
}
