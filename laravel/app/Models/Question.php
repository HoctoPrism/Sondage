<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'category'];
    protected $hidden = ['created_at', 'updated_at'];

    public function categories(): BelongsTo
    {
        return $this->BelongsTo(Category::class, 'category');
    }

    public function propositions(): HasMany
    {
        return $this->HasMany(Proposition::class, 'question');
    }

    public function sondages(): BelongsToMany
    {
        return $this->belongstoMany(
            Question::class,
            'sondage_question',
            'question',
            'sondage'
        );
    }
}
