<?php

namespace App\Gates\User;

enum GateNames : string
{
    case STORE = 'user.store';
    case SEARCH = 'user.search';
    case UPDATE = 'user.update';
    case VIEW = 'user.view';
}
