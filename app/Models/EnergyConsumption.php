<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EnergyConsumption extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'appliance_id',
        'date',
        'consumption',
    ];

    /**
     * The attributes that should be visible in serialization.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'appliance_id',
        'date',
        'consumption',
        'average_consumption',
        'created_at',
        'updated_at',
        'appliance',
    ];

    /**
     * @return BelongsTo
     */
    public function appliance(): BelongsTo
    {
        return $this->belongsTo(ApplianceType::class);
    }
}
