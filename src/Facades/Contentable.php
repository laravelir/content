<?php

namespace Laravelir\Contentable\Facades;

use Illuminate\Support\Facades\Facade;

class Contentable extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'contentable';
    }
}
