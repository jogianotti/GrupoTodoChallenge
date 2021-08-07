<?php declare(strict_types=1);

namespace App\Application\Product;

use App\Application\Category\CategoryFinder;
use App\Repository\ProductCategoryRepositoryInterface;
use App\Repository\ProductRepositoryInterface;

final class ProductUpdater
{
    private ProductRepositoryInterface $productRepository;
    private ProductCategoryRepositoryInterface $productCategoryRepository;
    private CategoryFinder $categoryFinder;

    public function __construct(
        ProductRepositoryInterface         $productRepository,
        ProductCategoryRepositoryInterface $productCategoryRepository,
        CategoryFinder                     $categoryFinder
    )
    {
        $this->productRepository = $productRepository;
        $this->productCategoryRepository = $productCategoryRepository;
        $this->categoryFinder = $categoryFinder;
    }

    public function __invoke(int $id, string $name, string $description, int $category_id): void
    {
        $product = $this->productRepository->one($id);
        $product->setName($name);
        $product->setDescription($description);

        $this->productRepository->save($product);

        $category = ($this->categoryFinder)($category_id);
        $productCategory = $this->productCategoryRepository->oneByProduct($product);

        $productCategory->setCategory($category);

        $this->productCategoryRepository->save($productCategory);

    }
}
