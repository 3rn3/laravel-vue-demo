<?php

namespace App\Repository\Enum\Permission;

enum PermissionName : string
{
    case USER_WRITE = 'user.write';
    case USER_READ = 'user.read';

    case PRODUCT_WRITE = 'product.write';
    case PRODUCT_READ = 'product.read';
}
