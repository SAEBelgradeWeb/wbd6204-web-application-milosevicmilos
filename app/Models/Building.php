<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int id
 */
final class Building extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'address',
    ];

    /**
     * The attributes that should be visible in serialization.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'value',
        'user_id',
        'user_name',
        'name',
        'label',
        'address',
        'floors',
        'floor_count',
        'user',
        'created_at',
        'updated_at',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'user_name',
        'floor_count',
        'value',
        'label',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'date:d M Y H:i',
        'updated_at' => 'date:d M Y H:i',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany
     */
    public function floors(): HasMany
    {
        return $this->hasMany(Floor::class);
    }

    /**
     * @return string
     */
    public function getUserNameAttribute(): string
    {
        return $this->user->getName();
    }

    /**
     * @return int
     */
    public function getFloorCountAttribute(): int
    {
        return $this->floors()->count();
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
