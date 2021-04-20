<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class ApplianceType extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'name',
    ];

    /**
     * The attributes that should be visible in serialization.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'value',
        'name',
        'label',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'value',
        'label',
    ];

    /**
     * @return HasMany
     */
    public function appliance(): HasMany
    {
        return $this->hasMany(Appliance::class);
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
