<?php

declare(strict_types=1);

namespace App\Domains\CRM\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property string $full_name
 * @property string $email_address
 * @property string $phone_number
 * @property string $pipeline_status
 * @property string $preferred_program_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Lead extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'crm_leads';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'email_address',
        'phone_number',
        'pipeline_status',
        'preferred_program_type',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'pipeline_status' => 'string',
            'preferred_program_type' => 'string',
        ];
    }
}
