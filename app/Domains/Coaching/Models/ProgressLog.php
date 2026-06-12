<?php

declare(strict_types=1);

namespace App\Domains\Coaching\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property int $user_id
 * @property string $log_date
 * @property float|null $weight
 * @property int $workout_completed_pct
 * @property int $diet_completed_pct
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class ProgressLog extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'progress_logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'log_date',
        'weight',
        'workout_completed_pct',
        'diet_completed_pct',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
            'weight' => 'float',
            'workout_completed_pct' => 'integer',
            'diet_completed_pct' => 'integer',
        ];
    }
}
