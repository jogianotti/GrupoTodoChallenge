<?php


namespace App\Repository;

use App\Entity\Categoria;

interface CategoryRepositoryInterface
{
    public function save(Categoria $category): void;

    public function all(): array;

    public function one(int $id): ?Categoria;

    public function remove(Categoria $category): void;

    public function allParents(): array;
}