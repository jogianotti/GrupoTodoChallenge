<?php declare(strict_types=1);

namespace App\Application\Product;

use App\Entity\Producto;
use App\Repository\ProductRepositoryInterface;

final class ProductFinder
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function __invoke(int $id): Producto
    {
        return $this->productRepository->one($id);
    }
}
