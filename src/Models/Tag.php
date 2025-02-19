<?php

namespace Laravelir\Contentable\Models;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Tag extends Model
{
    use SoftDeletes;

    protected $table = 'contentable_tags';

    protected $guarded = [];

    // protected $fillable = ['name', 'slug', 'deleted_at'];

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = (string)Uuid::uuid4();
        });
    }

    public function taggable(): MorphTo
    {
        return $this->morphTo();
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
