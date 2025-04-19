<?php

namespace App\Traits;

use Exception;
use Illuminate\Database\Eloquent\Builder;

trait HasSort
{
    public function scopeSort(Builder $query, ?array $sorts): void
    {
        if (empty($this->sortableKeys)) {
            throw new Exception('No sortable keys defined.');
        }

        if (! $sorts) {
            return;
        }

        if (! in_array($sorts['column'], $this->sortableKeys)) {
            return;
        }

        $query->orderBy($sorts['column'], $sorts['direction'] === 'asc' ? 'ASC' : 'DESC');
    }
}
