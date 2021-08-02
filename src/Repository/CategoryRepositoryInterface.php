<?php


namespace App\Repository;

use App\Entity\Categoria;

interface CategoryRepositoryInterface
{
    public function save(Categoria $category): void;
}