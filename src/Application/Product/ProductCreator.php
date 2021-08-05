<?php declare(strict_types=1);

namespace App\Application\Product;

use App\Application\Category\CategoryFinder;
use App\Entity\Producto;
use App\Repository\ProductRepositoryInterface;

final class ProductCreator
{
    private ProductRepositoryInterface $productRepository;
    private CategoryFinder $categoryFinder;

    public function __construct(ProductRepositoryInterface $productRepository, CategoryFinder $categoryFinder)
    {
        $this->productRepository = $productRepository;
        $this->categoryFinder = $categoryFinder;
    }

    public function __invoke(string $name, int $category_id): void
    {
        $category = ($this->categoryFinder)($category_id);
        $product = Producto::create($name, $category);

        $this->productRepository->save($product);
    }
}
