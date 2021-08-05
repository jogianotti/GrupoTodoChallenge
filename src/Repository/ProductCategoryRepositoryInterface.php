<?php


namespace App\Repository;

use App\Entity\ProductoCategoria;

interface ProductCategoryRepositoryInterface
{
    public function save(ProductoCategoria $productCategory);
}
