<?php

namespace Laravelir\Contentable\Traits;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Model;

trait Taggable
{
    protected static function booted()
    {
        static::deleted(function (Model $model) {
            foreach ($model->tags as $tag) {
                $tag->forceDelete();
            }
        });
    }

    public function tags()
    {
        return $this->tagsRelation();
    }

    public function tagsRelation(): MorphToMany
    {
        return $this->morphToMany(config('contentable.tags.model'), 'taggable', 'contentable_taggables');
    }

    public function attachTag($tag)
    {
        $this->tagsRelation()->attach($tag);
        $this->save();
    }

    public function detachTag($tag)
    {
        $this->tagsRelation()->detach($tag);
        $this->save();
    }

    public function syncTags(array $tags)
    {
        $this->tagsRelation()->sync($tags);
        $this->save();
    }

    public function hasTag($tag): bool
    {
        return $this->tags
            ->contains(function ($modelTag) use ($tag) {
                return $modelTag->name === $tag || $modelTag->id === $tag;
            });
    }
}
