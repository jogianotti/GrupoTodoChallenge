<?php declare(strict_types=1);

namespace App\Tests\Application\Product;

use App\Entity\Producto;
use Faker\Factory;
use Faker\Generator;

final class ProductMother
{
    private static ?Generator $factory;

    public static function create(): Producto
    {
        return Producto::create(
            self::factory()->word,
            self::factory()->text()
        );
    }

    public static function factory(): Generator
    {
        return self::$factory = self::$factory ?? Factory::create();
    }
}
