<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Reponse extends Model
{
    use HasFactory;
    protected $fillable = ['reponse', 'sondage', 'question'];

    public function sondages(): BelongsTo
    {
        return $this->BelongsTo(Sondage::class, 'sondage');
    }

    public function questions(): BelongsTo
    {
        return $this->BelongsTo(Question::class, 'question');
    }
}
