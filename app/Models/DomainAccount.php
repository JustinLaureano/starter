<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use LdapRecord\Laravel\Auth\AuthenticatesWithLdap;

class DomainAccount extends Model
{
    // TODO: fix all properties!

    use AuthenticatesWithLdap,
        HasUuids;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'guid';

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    // /**
    //  * The authentication guard driver for the user model.
    //  *
    //  * This variables only use is to enforce roles/permissions
    //  * and does not affect application authentication.
    //  */
    // protected string $guard_name = 'web';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'organization_id',
        'username',
        'first_name',
        'last_name',
        'display_name',
        'title',
        'description',
        'email',
        'domain',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * The attributes that are filterable.
     */
    protected array $filterable = [
        'username',
        'first_name',
        'last_name',
        'title',
        'description',
        'email',
    ];

    public static $objectClasses = [
        'top',
        'person',
        'organizationalperson',
        'user',
    ];

    /**
     * Get the DN field for the domain account.
     */
    public function getDn(): string
    {
        return $this->username;
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array<string, mixed>
     */
    public function toSearchableArray(): array
    {
        return [
            'username' => $this->username,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'title' => $this->title,
            'description' => $this->description,
            'email' => $this->email,
        ];
    }

    /**
     * Scope a query to filter on the first and last name columns.
     */
    public function scopeWhereName(Builder $query, string $firstName, string $lastName): void
    {
        $query->where([
            ['first_name', $firstName],
            ['last_name', $lastName]
        ]);
    }
}
