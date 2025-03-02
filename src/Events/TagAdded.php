<?php

namespace Laravelir\Contentable\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Laravelir\Contentable\Models\Tag;

class TagUpdated implements ShouldDispatchAfterCommit
{
    use SerializesModels, Dispatchable, InteractsWithSockets;

    public function __construct(public Model $model, public Tag $tag) {}
}
