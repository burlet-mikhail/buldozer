<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\Models\HasSlug;

class Page extends Model {
    use HasFactory, HasSlug;

    protected $fillable = [
        'title',
        'slug',
        'text',
    ];

    public static function slugFrom(): string {
        return 'title';
    }

    public static function slugColumn(): string {
        return 'slug';
    }
}
