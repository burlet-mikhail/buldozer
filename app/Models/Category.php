<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Support\Traits\Models\HasSlug;
use Support\Traits\Models\HasThumbnail;

class Category extends Model {
    use HasFactory, HasThumbnail, HasSlug;

    protected $fillable = [
        'name',
        'slug',
        'active',
        'group_id',
        'description',
        'parent',
        'show_in_home',
        'show_in_menu',
        'show_in_popular',
        'show_in_not_popular',
        'thumbnail',
    ];

    public function products(): BelongsToMany {
        return $this->belongsToMany( Product::class );
    }

    public function options(): BelongsToMany {
        return $this->belongsToMany( Option::class );
    }

    public function childs(): HasMany {
        return $this->hasMany( Category::class, 'parent', 'id' );
    }

    public function parent(): BelongsTo {
        return $this->belongsTo( Category::class, 'parent' );
    }

    public function thumbnailDir(): string {
        return 'categories';
    }
}
