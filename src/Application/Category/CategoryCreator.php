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

    public function __invoke(string $name, ?string $description, ?int $parent_id): void
    {
        $category = Categoria::create($name, $description);

        if ($parent_id) {
            $parent = $this->categoryRepository->one($parent_id);
            $category->setParent($parent);
        }
        
        $this->categoryRepository->save($category);
    }
}
