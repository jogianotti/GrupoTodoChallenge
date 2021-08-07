<?php declare(strict_types=1);

namespace App\Application\Product;

use App\Exceptions\Product\ProductNotFoundException;
use App\Repository\ProductCategoryRepositoryInterface;
use App\Repository\ProductRepositoryInterface;

final class ProductRemover
{
    private ProductRepositoryInterface $productRepository;
    private ProductCategoryRepositoryInterface $productCategoryRepository;

    public function __construct(
        ProductRepositoryInterface         $productRepository,
        ProductCategoryRepositoryInterface $productCategoryRepository
    )
    {
        $this->productRepository = $productRepository;
        $this->productCategoryRepository = $productCategoryRepository;
    }

    public function __invoke(int $id): void
    {
        $product = $this->productRepository->one($id);

        if (!$product) {
            throw new ProductNotFoundException();
        }

        $productCategory = $this->productCategoryRepository->oneByProduct($product);

        $this->productCategoryRepository->remove($productCategory);
        $this->productRepository->remove($product);

    }
}
