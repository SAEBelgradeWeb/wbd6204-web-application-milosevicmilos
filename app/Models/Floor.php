<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Floor extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'building_id',
        'name',
        'level',
    ];

    /**
     * The attributes that should be visible in serialization.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'value',
        'building_id',
        'building_name',
        'name',
        'label',
        'level',
        'rooms',
        'room_count',
        'created_at',
        'updated_at',
        'building'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'building_name',
        'room_count',
        'value',
        'label',
    ];

    /**
     * @return BelongsTo
     */
    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }

    /**
     * @return HasMany
     */
    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    /**
     * @return string
     */
    public function getBuildingNameAttribute(): string
    {
        return $this->building->name;
    }

    /**
     * @return int
     */
    public function getRoomCountAttribute(): int
    {
        return $this->rooms()->count();
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
