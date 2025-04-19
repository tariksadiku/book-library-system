<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait HasCacheKey
{
    public function cacheKey(string $prefix = ''): string
    {
        if ($this instanceof Model) {
            return $this::class.'_'.$this->id.'_'.$this->updated_at->timestamp;
        }

        return $this::class.'_'.$prefix;
    }
}
