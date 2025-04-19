<?php

namespace App\Models;

use App\Traits\HasCacheKey;
use App\Traits\HasSearch;
use App\Traits\HasSort;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    use HasCacheKey, HasSearch, HasSort;

    protected $fillable = ['title', 'isbn', 'cover_url', 'author_id'];

    protected array $searchKeys = ['title', 'isbn'];

    protected array $sortableKeys = ['title', 'isbn'];

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }
}
