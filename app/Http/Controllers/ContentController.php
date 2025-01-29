<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function create()
    {
        $providers = ['deepseek', 'openai', 'anthropic'];
        return view('create', compact('providers'));
    }
}
