<?php

namespace Laravelir\Contentable\Models;

use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Tag extends Model
{
    use SoftDeletes;

    protected $table = 'contentable_tags';

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = (string)Uuid::uuid4();
            $model->slug = Str::slug($model->title);
        });
    }

    public function taggable(): MorphTo
    {
        return $this->morphTo();
    }

    // public function sluggable(): array
    // {
    //     return [
    //         'slug' => [
    //             'source' => 'title'
    //         ]
    //     ];
    // }
}
