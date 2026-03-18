<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Student extends Model
{
    protected $fillable = ['student_identifier', 'name'];

    /**
     * A student can take many evaluations over time.
     */
    public function evaluations(): BelongsToMany
    {
        return $this->belongsToMany(Evaluation::class)
                    ->withPivot('final_score')
                    ->withTimestamps();
    }

    /**
     * A student has many factors (their specific hits per exam/presentation).
     */
    public function factors(): BelongsToMany
    {
        return $this->belongsToMany(Factor::class)
                    ->withPivot('evaluation_id', 'hits')
                    ->withTimestamps();
    }
}
