<?php declare(strict_types=1);

namespace App\Application\Category;

use App\Repository\CategoryRepositoryInterface;
use BlueM\Tree;

final class MenuMaker
{
    private CategoryRepositoryInterface $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function __invoke(): array
    {
        $data = $this->categoryRepository->allParents();

        $tree = new Tree($data);

        return $this->menu($tree->getRootNodes(), 0);
    }

    private function menu($categories, $level): array
    {
        $menu = array();

        foreach ($categories as $category) {
            $menu[] = [
                'id' => $category->getId(),
                'name' => $category->getName(),
                'level' => $level
            ];

            if ($category->hasChildren()) {
                $menu = array_merge($menu, $this->menu($category->getChildren(), ++$level));
            }
        }

        return $menu;
    }
}
