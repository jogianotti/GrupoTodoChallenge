<?php declare(strict_types=1);

namespace App\Application\Category;

use App\Repository\CategoryRepositoryInterface;

final class MenuMaker
{
    private CategoryRepositoryInterface $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function __invoke()
    {
        $categories = $this->categoryRepository->allParents();

        return $this->menu($categories);
    }

    private function menu($categories): array
    {
        $menu = array();

        foreach ($categories as $category) {
            $menu[] = [
                'id' => $category->getId(),
                'name' => $category->getName()
            ];
        }

        return $menu;
    }
}
