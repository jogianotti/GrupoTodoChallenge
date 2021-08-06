<?php declare(strict_types=1);

namespace App\Application\Product;

use App\Repository\ProductRepositoryInterface;

final class AllProductsFinder
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function __invoke(): array
    {
        return $this->productRepository->all();
    }
}
