<?php


namespace App\Repository;

use App\Entity\Producto;

interface ProductRepositoryInterface
{
    public function save(Producto $product): void;

    public function all(): array;

    public function one(int $id): ?Producto;
}