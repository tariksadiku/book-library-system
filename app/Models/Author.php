<?php

namespace App\Models;

use App\Traits\HasCacheKey;
use App\Traits\HasSearch;
use App\Traits\HasSort;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Author extends Model
{
    use HasCacheKey, HasSearch, HasSort;

    protected $fillable = ['name', 'birth_date', 'biography'];

    protected array $searchKeys = ['name', 'birth_date', 'biography'];

    protected array $sortableKeys = ['name', 'birth_date', 'biography'];

    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}
