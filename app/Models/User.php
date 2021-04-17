<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int id
 * @property string first_name
 * @property string last_name
 * @property string email
 * @property string role
 */
final class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    public const ROLE_ADMIN = 'ADMIN';
    public const ROLE_REGULAR = 'REGULAR';

    public const ROLES = [
        self::ROLE_ADMIN,
        self::ROLE_REGULAR
    ];

    public const ROLE_NAMES = [
        self::ROLE_ADMIN => 'Admin',
        self::ROLE_REGULAR => 'Regular'
    ];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be visible in serialization.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'value',
        'first_name',
        'last_name',
        'email',
        'role',
        'role_name',
        'label',
        'status',
        'created_at',
        'updated_at',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'role_name',
        'status',
        'value',
        'label',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
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
     * @return HasMany
     */
    public function buildings(): HasMany
    {
        return $this->hasMany(Building::class);
    }

    /**
     * @param string $userRole
     * @return bool
     */
    public function hasRole(string $userRole): bool
    {
        if ($this->role !== $userRole) {
            return false;
        }

        return true;
    }

    /**
     * @return string
     */
    public function getStatusAttribute(): string
    {
        if ($this->deleted_at !== null) {
            return 'Deleted';
        }

        if ($this->email_verified_at === null) {
            return 'Inactive';
        }

        return 'Active';
    }

    /**
     * @return string
     */
    public function getRoleNameAttribute(): string
    {
        return self::ROLE_NAMES[$this->role];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * @return string
     */
    public function getLabelAttribute(): string
    {
        return $this->getName();
    }

    /**
     * @return string
     */
    public function getValueAttribute(): string
    {
        return $this->id;
    }
}
