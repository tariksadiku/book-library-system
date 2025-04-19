<?php

namespace App\Models;

use App\Traits\HasCacheKey;
use App\Traits\HasSearch;
use App\Traits\HasSort;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class Author extends Model
{
    use HasCacheKey, HasSearch, HasSort;

    protected $fillable = ['name', 'birth_date', 'biography'];

    protected array $searchKeys = ['name', 'birth_date', 'biography'];

    protected array $sortableKeys = ['name', 'birth_date', 'biography'];

    protected static function booted()
    {
        static::updated(function (Model $author) {
            $author->books->each(function (Model $book) {
                $bookCache = $book->cacheKey();

                Cache::forget($bookCache);
            });
        });
    }

    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}
