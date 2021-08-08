<?php declare(strict_types=1);

namespace App\Application\Product;

use App\Repository\ProductCategoryRepositoryInterface;

final class ProductsByCategoryFinder
{
    private ProductCategoryRepositoryInterface $productCategoryRepository;

    public function __construct(ProductCategoryRepositoryInterface $productCategoryRepository)
    {
        $this->productCategoryRepository = $productCategoryRepository;
    }

    public function __invoke(int $id): array
    {
        return $this->productCategoryRepository->byCategory($id);
    }
}
