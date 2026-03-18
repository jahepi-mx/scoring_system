<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Factor extends Model
{
    protected $fillable = [
        'evaluation_id',
        'name',
        'percentage',
        'total_hits'
    ];

    /**
     * A factor belongs to one specific evaluation.
     */
    public function evaluation(): BelongsTo
    {
        return $this->belongsTo(Evaluation::class);
    }

    /**
     * A factor belongs to many students (recording their specific hits).
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class)
                    ->withPivot('evaluation_id', 'hits')
                    ->withTimestamps();
    }
}
