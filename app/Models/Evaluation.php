<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Evaluation extends Model
{
    protected $fillable = ['name'];

    /**
     * An evaluation has many factors (Exam, Participation, etc.)
     */
    public function factors(): HasMany
    {
        return $this->hasMany(Factor::class);
    }

    /**
     * An evaluation belongs to many students.
     * Includes the final calculated score for this specific evaluation.
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class)
                    ->withPivot('final_score')
                    ->withTimestamps();
    }
}
