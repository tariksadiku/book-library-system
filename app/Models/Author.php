<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\HasSearch;
use App\Traits\HasSort;

class Author extends Model
{
    use HasSearch, HasSort;
    protected $fillable = ['name'];
    
    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}
