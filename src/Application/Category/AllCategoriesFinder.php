<?php declare(strict_types=1);

namespace App\Application\Category;

use App\Repository\CategoryRepositoryInterface;

final class AllCategoriesFinder
{
    private CategoryRepositoryInterface $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function __invoke()
    {
        return $this->categoryRepository->all();
    }
}
