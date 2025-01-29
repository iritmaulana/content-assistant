<?php

namespace App\Services\LLM;

use App\Interfaces\LLMProviderInterface;
use Illuminate\Support\Facades\Http;

class DeepseekProvider implements LLMProviderInterface
{
    public function generateContent(string $prompt, array $options = []): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.deepseek.api_key'),
                'Content-Type' => 'application/json',
            ])->post(config('llm.deepseek.base_url') . '/v1/completions', [
                'prompt' => $prompt,
                'max_tokens' => $options['max_tokens'] ?? 1000,
                'temperature' => $options['temperature'] ?? 0.7,
            ]);

            return [
                'success' => true,
                'content' => $response->json()['choices'][0]['text'] ?? '',
                'provider' => 'deepseek'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'Deepseek API error: ' . $e->getMessage(),
                'provider' => 'deepseek'
            ];
        }
    }
}
