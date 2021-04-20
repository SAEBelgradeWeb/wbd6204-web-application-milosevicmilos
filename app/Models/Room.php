<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Room extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'floor_id',
        'name',
        'size',
    ];

    /**
     * The attributes that should be visible in serialization.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'value',
        'building_name',
        'floor_id',
        'floor_name',
        'name',
        'label',
        'size',
        'created_at',
        'updated_at',
        'appliances_count',
        'floor',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'building_name',
        'floor_name',
        'appliances_count',
        'value',
        'label',
    ];

    /**
     * @return BelongsTo
     */
    public function floor(): BelongsTo
    {
        return $this->belongsTo(Floor::class);
    }

    /**
     * @return HasMany
     */
    public function appliances(): HasMany
    {
        return $this->hasMany(Appliance::class);
    }

    /**
     * @return string
     */
    public function getBuildingNameAttribute(): string
    {
        return $this->floor->building_name;
    }


    /**
     * @return string
     */
    public function getFloorNameAttribute(): string
    {
        return $this->floor->name;
    }

    /**
     * @return int
     */
    public function getAppliancesCountAttribute(): int
    {
        return $this->appliances()->count();
    }

    /**
     * @return string
     */
    public function getLabelAttribute(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getValueAttribute(): string
    {
        return $this->id;
    }
}
