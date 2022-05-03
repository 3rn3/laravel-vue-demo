<?php

namespace App\Repository\Enum\Product;

enum Status : int
{
    case Active = 1;
    case Hold = 2;
    case Inactive = 3;

    public static function toArray(): array
    {
        return [1, 2, 3];
    }

    public function toString(): string
    {
        return match ($this) {
            Status::Active => 'Active',
            Status::Hold => 'Hold',
            Status::Inactive => 'Inactive'
        };
    }
}
