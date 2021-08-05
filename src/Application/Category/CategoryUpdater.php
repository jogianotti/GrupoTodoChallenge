<?php declare(strict_types=1);

namespace App\Application\Category;

use App\Entity\Categoria;
use App\Exceptions\Category\CategoryNotFoundException;
use App\Repository\CategoryRepositoryInterface;

final class CategoryUpdater
{
    private CategoryRepositoryInterface $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function __invoke(int $id, string $name, ?string $description, ?int $parent)
    {
        $category = $this->findCategory($id);

        $category->setName($name);
        $category->setDescription($description);

        $this->categoryRepository->save($category);
    }

    private function findCategory(int $id): Categoria
    {
        $category = $this->categoryRepository->one($id);

        if (!$category) {
            throw new CategoryNotFoundException();
        }

        return $category;
    }
}
