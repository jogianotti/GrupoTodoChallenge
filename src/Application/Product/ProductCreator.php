<?php declare(strict_types=1);

namespace App\Application\Product;

use App\Application\Category\CategoryFinder;
use App\Entity\Producto;
use App\Entity\ProductoCategoria;
use App\Repository\ProductCategoryRepositoryInterface;
use App\Repository\ProductRepositoryInterface;

final class ProductCreator
{
    private ProductRepositoryInterface $productRepository;
    private CategoryFinder $categoryFinder;
    private ProductCategoryRepositoryInterface $productCategoryRepository;

    public function __construct(
        ProductRepositoryInterface         $productRepository,
        ProductCategoryRepositoryInterface $productCategoryRepository,
        CategoryFinder                     $categoryFinder)
    {
        $this->productRepository = $productRepository;
        $this->categoryFinder = $categoryFinder;
        $this->productCategoryRepository = $productCategoryRepository;
    }

    public function __invoke(string $name, ?string $description, int $category_id): void
    {
        $category = ($this->categoryFinder)($category_id);
        $product = Producto::create($name, $description);

        $this->productRepository->save($product);

        $productCategory = ProductoCategoria::create($product, $category);

        $this->productCategoryRepository->save($productCategory);
    }
}
