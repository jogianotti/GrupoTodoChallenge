<?php declare(strict_types=1);

namespace App\Application\Product;

use App\Exceptions\Product\ProductNotFoundException;
use App\Repository\ProductRepositoryInterface;

final class ProductRemover
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function __invoke(int $id): void
    {
        $product = $this->productRepository->one($id);

        if (!$product) {
            throw new ProductNotFoundException();
        }

        $this->productRepository->remove($product);

    }
}
