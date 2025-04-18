<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasSort
{
    public function scopeSort(Builder $query, ?array $sorts): void
    {
        $allowed = ['name', 'title', 'isbn'];

        foreach ($sorts as $column => $direction) {
            if (in_array($column, $allowed)) {
                $query->orderBy($column, strtoupper($direction) === 'DESC' ? 'DESC' : 'ASC');
            }
        }
    }
}
