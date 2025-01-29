<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;
    protected $table = 'contents';
    protected $fillable = [
        'title',
        'prompt',
        'type',
        'provider',
        'generated_content',
    ];

    protected $casts = [
        'generated_content' => 'array',
    ];


    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('d M Y, H:i');
    }
}
