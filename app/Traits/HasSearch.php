<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasSearch
{
    public function scopeSearch(Builder $query, ?string $search): void
    {
        if (! empty($search)) {
            $query->where('name', 'like', '%'.$search.'%');
        }
    }
}
