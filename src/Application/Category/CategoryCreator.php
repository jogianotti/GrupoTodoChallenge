<?php declare(strict_types=1);

namespace App\Application\Category;

use App\Entity\Categoria;
use App\Repository\CategoryRepositoryInterface;

final class CategoryCreator
{
    private CategoryRepositoryInterface $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function __invoke(string $name, ?int $parent_id): void
    {
        $category = Categoria::create($name);

        $this->categoryRepository->save($category);
    }
}
