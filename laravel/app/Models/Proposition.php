<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proposition extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'question'];
    protected $hidden = ['created_at', 'updated_at'];

    public function question(): BelongsTo
    {
        return $this->BelongsTo(Question::class, 'question');
    }
}
