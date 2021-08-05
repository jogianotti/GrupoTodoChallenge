<?php declare(strict_types=1);

namespace App\Application\Category;

use App\Entity\Categoria;
use App\Repository\CategoryRepositoryInterface;

final class CategoryFinder
{
    private CategoryRepositoryInterface $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function __invoke($id): ?Categoria
    {
        return $this->categoryRepository->one($id);
    }
}
