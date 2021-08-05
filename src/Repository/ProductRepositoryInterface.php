<?php


namespace App\Repository;

use App\Entity\Producto;

interface ProductRepositoryInterface
{
    public function save(Producto $product);
}