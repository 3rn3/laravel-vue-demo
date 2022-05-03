<?php

namespace App\Repository\Enum\Permission;

enum SearchFields : string
{
    case ID = 'id';
    case NAME = 'name';
    case DISPLAY_LABEL = 'display_label';
}
