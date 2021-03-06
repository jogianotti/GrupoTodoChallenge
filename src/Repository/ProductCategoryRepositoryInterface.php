<?php


namespace App\Repository;

use App\Entity\Producto;
use App\Entity\ProductoCategoria;

interface ProductCategoryRepositoryInterface
{
    public function save(ProductoCategoria $productCategory);

    public function oneByProduct(Producto $product): ProductoCategoria;

    public function remove(ProductoCategoria $productCategory): void;

    public function byCategory(int $id): array;
}
