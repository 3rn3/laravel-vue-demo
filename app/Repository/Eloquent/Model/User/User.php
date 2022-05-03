<?php

namespace App\Repository\Eloquent\Model\User;

use App\Repository\Eloquent\Model\Permission\Helper\AddTableToPermissionField;
use App\Repository\Eloquent\Model\Permission\Permission;
use App\Repository\Eloquent\Model\UserPermission\UserPermission;
use App\Repository\Interfaces\Model\Permission\IPermission;
use App\Repository\Interfaces\Model\User\IUser;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements IUser
{
    use HasApiTokens, HasFactory, Notifiable;

    public const TABLE_NAME = 'users';
    public const ID = 'id';
    public const NAME = 'name';
    public const EMAIL = 'email';
    public const PASSWORD = 'password';
    public const ACTIVE = 'active';


    protected $table = self::TABLE_NAME;
    protected $guarded = [self::ID];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        self::PASSWORD,
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        self::ACTIVE => 'boolean',
    ];

    public function getId(): int
    {
        return $this->{self::ID};
    }

    public function getName(): string
    {
        return $this->{self::NAME};
    }

    public function getEmail(): string
    {
        return $this->{self::EMAIL};
    }

    public function getPassword(): string
    {
        return $this->{self::PASSWORD};
    }

    public function isActive(): bool
    {
        return  $this->{self::ACTIVE};
    }

    public function hasPermission(string $permission): bool
    {
        return $this->permissions()
                ->where(AddTableToPermissionField::addTableToPermissionField(Permission::NAME), '=', $permission)
                ->first() instanceof IPermission;
    }

    public function getPermissions(): Collection
    {
        return $this->permissions;
    }


    /*------------- Relationships ---------------*/
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, UserPermission::TABLE_NAME, UserPermission::USER_ID, UserPermission::PERMISSION_ID);
    }
    /*----------- Relationships --------------*/


}
