<?php

namespace App\Traits;

use Exception;
use Illuminate\Database\Eloquent\Builder;

trait HasSearch
{
    public function scopeSearch(Builder $query, ?string $search): void
    {
        if (empty($this->searchKeys)) {
            throw new Exception('No searchable fields defined in the model.');
        }
        if (empty($search)) {
            return;
        }

        foreach ($this->searchKeys as $field) {
            $query->orWhere($field, 'like', "%{$search}%");
        }
    }
}
