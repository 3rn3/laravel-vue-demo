<?php

namespace App\Repository\Eloquent\Model\Permission;

use App\Repository\Interfaces\Model\Permission\IPermission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission  extends Model implements IPermission
{
    use HasFactory;

    public const TABLE_NAME = 'permissions';
    public const ID = 'id';
    public const NAME = 'name';
    public const DISPLAY_LABEL = 'display_label';


    protected $table = self::TABLE_NAME;
    protected $guarded = [self::ID];

    public function getId(): int
    {
        return $this->{self::ID};
    }

    public function getUniqueName(): string
    {
        return $this->{self::NAME};
    }

    public function getDisplayLabel(): string
    {
        return $this->{self::DISPLAY_LABEL};
    }

}
