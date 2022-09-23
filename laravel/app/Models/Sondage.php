<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sondage extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function questions(): BelongsToMany
    {
        return $this->belongstoMany(
            Question::class,
            'sondage_question',
            'sondage',
            'question'
        );
    }

    public function reponses(): HasMany
    {
        return $this->HasMany(Reponse::class, 'reponse');
    }
}
