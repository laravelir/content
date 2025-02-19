<?php

namespace Laravelir\Contentable\Models;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Category extends Model
{
    use SoftDeletes;

    protected $table = 'contentable_categories';

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = (string)Uuid::uuid4();
        });
    }

    public function categoriable(): MorphTo
    {
        return $this->morphTo();
    }

    public function parent()
    {
        return $this->hasOne(Category::class, 'id', 'parent_id')->withDefault(['title' => '---']);
    }

    function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function hasChildren(): bool
    {
        return $this->children()->count() > 0;
    }

    // /**
    //  * Get all of the books that are assigned this tag.
    //  */
    // public function books()
    // {
    //     return $this->morphedByMany(Book::class, 'categoriable', 'categoriables');
    // }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
