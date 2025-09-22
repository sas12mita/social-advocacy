<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'heading',
        'nep_heading',
        'slug',
        'category_id',
        'body',
        'nep_body',
        'image',
        'view',
        'published_status'
    ];

    protected $casts = [
        'image' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
