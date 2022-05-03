<?php

namespace App\Repository\Eloquent\Model\Product;

use App\Repository\Enum\Product\Status;
use App\Repository\Interfaces\Model\Product\IProduct;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model implements IProduct
{
    use HasFactory;

    public const TABLE_NAME = 'products';
    public const ID = 'id';
    public const NAME = 'name';
    public const STATUS = 'status';
    public const PRICE = 'price';


    protected $table = self::TABLE_NAME;
    protected $guarded = [self::ID];

    public function getId(): int
    {
        return $this->{self::ID};
    }

    public function getName(): string
    {
        return $this->{self::NAME};
    }

    public function getStatus(): Status
    {
        return $this->{self::STATUS};
    }

    public function getPrice(): float
    {
        return $this->{self::PRICE};
    }


    /**
     * Get the user's first name.
     *
     * @return Attribute
     */
    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Status::from($value),
        );
    }
}
