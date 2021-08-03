<?php declare(strict_types=1);

namespace App\Tests\Application\Category;

use App\Entity\Categoria;
use Faker\Factory;
use Faker\Generator;

final class CategoryMother
{
    private static ?Generator $factory;

    public static function create(): Categoria
    {
        return Categoria::create(
            self::factory()->word,
            self::factory()->text,
        );
    }

    public static function factory(): Generator
    {
        return self::$factory = self::$factory ?? Factory::create();
    }
}
