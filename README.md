# Content Assistant

A flexible Laravel application that integrates with various Language Model (LLM) providers like OpenAI, Anthropic, and Deepseek for content generation. This application provides a modern interface for generating different types of content using various AI models.

## Features

-   🤖 Support for multiple LLM providers (OpenAI, Anthropic, Deepseek)
-   📝 Generate different types of content (blog posts, social media, emails)
-   🎨 Modern and responsive user interface
-   ⚡ Real-time parameter adjustments
-   🔄 Extensible architecture for adding new providers
-   📊 Content history and management
-   ⚙️ Configurable generation parameters

## Requirements

-   PHP 8.2 or higher
-   Laravel 11.x
-   Composer
-   MySQL/PostgreSQL
-   API keys for LLM providers

## Installation

1. Clone the repository:

```bash
git clone https://github.com/iritmaulana/content-assistant.git
cd content-assistant
```

2. Install dependencies:

```bash
composer install
```

3. Copy environment file and configure:

```bash
cp .env.example .env
```

4. Set up your database and LLM API keys in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=content_assistant
DB_USERNAME=root
DB_PASSWORD=

OPENAI_API_KEY=your_openai_key
ANTHROPIC_API_KEY=your_anthropic_key
DEEPSEEK_API_KEY=your_deepseek_key
```

5. Generate application key:

```bash
php artisan key:generate
```

6. Run migrations:

```bash
php artisan migrate
```

7. Start the development server:

```bash
php artisan serve
```

## Project Structure

```
app/
├── Interfaces/
│   └── LLMProviderInterface.php
├── Services/
│   ├── LLM/
│   │   ├── DeepseekProvider.php
│   │   ├── OpenAIProvider.php
│   │   └── AnthropicProvider.php
│   └── LLMFactory.php
├── Http/
│   └── Controllers/
│       └── ContentController.php
└── Models/
    └── Content.php
```

## Adding New LLM Providers

1. Create a new provider class in `app/Services/LLM/`:

```php
namespace App\Services\LLM;

use App\Interfaces\LLMProviderInterface;

class NewProvider implements LLMProviderInterface
{
    public function generateContent(string $prompt, array $options = []): array
    {
        // Implementation
    }
}
```

2. Add provider configuration in `config/llm.php`:

```php
'new_provider' => [
    'api_key' => env('NEW_PROVIDER_API_KEY'),
    'base_url' => env('NEW_PROVIDER_BASE_URL'),
],
```

3. Register the provider in `LLMFactory.php`:

```php
public static function make(string $provider): LLMProviderInterface
{
    return match ($provider) {
        'new_provider' => new NewProvider(),
        // ... other providers
    };
}
```

## API Response Format

All LLM providers must return responses in this format:

```php
[
    'success' => bool,
    'content' => string,
    'provider' => string,
    'error' => string|null
]
```

## Usage Examples

### Generate Content via Controller

```php
class ContentController extends Controller
{
    public function store(Request $request)
    {
        $llm = LLMFactory::make($request->provider);
        $result = $llm->generateContent($request->prompt, [
            'max_tokens' => $request->max_tokens,
            'temperature' => $request->temperature
        ]);

        // Handle result
    }
}
```

### Direct Provider Usage

```php
$provider = LLMFactory::make('openai');
$result = $provider->generateContent(
    "Write a blog post about AI",
    ['max_tokens' => 1000]
);
```

## Available Content Types

-   Blog Posts
-   Social Media Posts
-   Email Templates

Each type can be customized with:

-   Title
-   Prompt
-   Generation parameters (temperature, max tokens)
-   Provider selection

## Configuration

Key configuration options in `config/sercives.php`:

```php
return [
    'openai' => [
        'api_key' => env('OPENAI_API_KEY'),
    ],
    'anthropic' => [
        'api_key' => env('ANTHROPIC_API_KEY'),
    ],
    'deepseek' => [
        'api_key' => env('DEEPSEEK_API_KEY'),
        'base_url' => env('DEEPSEEK_BASE_URL'),
    ],
];
```

## Contributing

1. Fork the repository
2. Create a feature branch: `git checkout -b feature/new-feature`
3. Commit changes: `git commit -am 'Add new feature'`
4. Push to the branch: `git push origin feature/new-feature`
5. Submit a pull request

## Security

Please do not include any API keys in your code or pull requests. Always use environment variables for sensitive data.

## Acknowledgments

-   Laravel team for the amazing framework
-   All LLM providers for their APIs
-   Bootstrap team for the UI framework

## Support

For issues and feature requests, please use the GitHub issue tracker.

## Todo

-   [ ] Add support for more LLM providers
-   [ ] Implement caching for API responses
-   [ ] Add batch processing capability
-   [ ] Create API documentation
-   [ ] Add more content types
-   [ ] Implement user feedback system
