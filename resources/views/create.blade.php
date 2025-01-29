<!-- resources/views/contents/create.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Content Assistant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            color: #2c3e50;
        }

        .content-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            background: white;
        }

        .card-header {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            padding: 1.5rem;
        }

        .provider-icon {
            width: 24px;
            height: 24px;
            margin-right: 8px;
        }

        .form-control,
        .form-select {
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 0.75rem;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .btn-generate {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            border: none;
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-generate:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2);
        }

        .parameter-card {
            background: #f8fafc;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .provider-option {
            display: flex;
            align-items: center;
            padding: 0.5rem;
        }

        .prompt-tips {
            font-size: 0.875rem;
            color: #64748b;
            margin-top: 0.5rem;
        }

        /* Custom range slider styling */
        .form-range {
            height: 1.5rem;
            padding: 0;
            background: transparent;
        }

        .form-range::-webkit-slider-thumb {
            background: #6366f1;
        }

        .parameter-value {
            font-weight: 500;
            color: #6366f1;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="content-card card">
                    <div class="card-header">
                        <h2 class="h3 mb-0 d-flex align-items-center">
                            <i class="fas fa-magic me-2"></i>
                            Content Assistant
                        </h2>
                    </div>
                    <div class="card-body p-4">
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('contents.store') }}" method="POST">
                            @csrf

                            <div class="mb-4">
                                <label for="title" class="form-label fw-medium">Project Title</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    id="title" name="title" value="{{ old('title') }}"
                                    placeholder="Enter a descriptive title for your content" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-medium">Select AI Provider</label>
                                <div class="row g-3">
                                    @foreach ($providers as $provider)
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="provider"
                                                    id="provider_{{ $provider }}" value="{{ $provider }}"
                                                    {{ old('provider') == $provider ? 'checked' : '' }} required>
                                                <label class="form-check-label provider-option"
                                                    for="provider_{{ $provider }}">
                                                    <i class="fas fa-robot provider-icon"></i>
                                                    {{ ucfirst($provider) }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="type" class="form-label fw-medium">Content Type</label>
                                <select class="form-select @error('type') is-invalid @enderror" id="type"
                                    name="type" required>
                                    <option value="">Choose content type...</option>
                                    <option value="blog" {{ old('type') == 'blog' ? 'selected' : '' }}>
                                        <i class="fas fa-blog"></i> Blog Post
                                    </option>
                                    <option value="social" {{ old('type') == 'social' ? 'selected' : '' }}>
                                        <i class="fas fa-share-alt"></i> Social Media Post
                                    </option>
                                    <option value="email" {{ old('type') == 'email' ? 'selected' : '' }}>
                                        <i class="fas fa-envelope"></i> Email Template
                                    </option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="prompt" class="form-label fw-medium">Your Prompt</label>
                                <textarea class="form-control @error('prompt') is-invalid @enderror" id="prompt" name="prompt" rows="5"
                                    placeholder="Describe what you want to create..." required>{{ old('prompt') }}</textarea>
                                <div class="prompt-tips">
                                    <i class="fas fa-lightbulb me-1"></i>
                                    Tip: Be specific about tone, style, and target audience for better results.
                                </div>
                            </div>

                            <div class="parameter-card">
                                <h5 class="mb-3">Generation Parameters</h5>

                                <div class="mb-3">
                                    <label for="temperature" class="form-label d-flex justify-content-between">
                                        Creativity Level
                                        <span class="parameter-value">
                                            <span id="temperatureValue">0.7</span>
                                        </span>
                                    </label>
                                    <input type="range" class="form-range" id="temperature" name="temperature"
                                        min="0" max="1" step="0.1"
                                        value="{{ old('temperature', 0.7) }}">
                                    <div class="d-flex justify-content-between small text-muted">
                                        <span>Focused</span>
                                        <span>Balanced</span>
                                        <span>Creative</span>
                                    </div>
                                </div>

                                <div class="mb-0">
                                    <label for="max_tokens" class="form-label d-flex justify-content-between">
                                        Content Length
                                        <span class="parameter-value">
                                            <span id="tokensValue">1000</span> tokens
                                        </span>
                                    </label>
                                    <input type="range" class="form-range" id="max_tokens" name="max_tokens"
                                        min="100" max="4000" step="100"
                                        value="{{ old('max_tokens', 1000) }}">
                                    <div class="d-flex justify-content-between small text-muted">
                                        <span>Short</span>
                                        <span>Medium</span>
                                        <span>Long</span>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-generate btn-lg text-white">
                                    <i class="fas fa-wand-magic-sparkles me-2"></i>
                                    Generate Content
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Update range input values
        document.getElementById('temperature').addEventListener('input', function(e) {
            document.getElementById('temperatureValue').textContent = e.target.value;
        });

        document.getElementById('max_tokens').addEventListener('input', function(e) {
            document.getElementById('tokensValue').textContent = e.target.value;
        });
    </script>
</body>

</html>
