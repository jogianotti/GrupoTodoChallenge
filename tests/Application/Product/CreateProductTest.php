<?php declare(strict_types=1);

namespace App\Tests\Application\Product;

use App\Application\Category\CategoryFinder;
use App\Application\Product\ProductCreator;
use App\Entity\ProductoCategoria;
use App\Repository\CategoryRepositoryInterface;
use App\Repository\ProductCategoryRepositoryInterface;
use App\Repository\ProductRepositoryInterface;
use App\Tests\Application\Category\CategoryMother;
use Hamcrest\Matchers;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

final class CreateProductTest extends TestCase
{
    /**
     * @var ProductRepositoryInterface|MockInterface
     */
    private $productRepository;

    /**
     * @var CategoryRepositoryInterface|MockInterface
     */
    private $categoryRepository;

    /**
     * @var ProductCategoryRepositoryInterface|MockInterface
     */
    private $productCategoryRepository;

    /** @doesNotPerformAssertions */
    public function testItShouldCreateAProduct()
    {
        $product = ProductMother::create();
        $category = CategoryMother::create();
        $productCategory = ProductoCategoria::create($product, $category);
        $category_id = 1;

        $this->categoryRepository
            ->shouldReceive('one')
            ->with($category_id)
            ->once()
            ->andReturn($category);

        $this->productRepository
            ->shouldReceive('save')
            ->with(Matchers::equalTo($product))
            ->once();

        $this->productCategoryRepository
            ->shouldReceive('save')
            ->with(Matchers::equalTo($productCategory))
            ->once();

        (new ProductCreator(
            $this->productRepository,
            $this->productCategoryRepository,
            new CategoryFinder($this->categoryRepository)
        ))(
            $product->getName(),
            $product->getDescription(),
            $category_id
        );
    }

    protected function setUp(): void
    {
        $this->productRepository = Mockery::mock(ProductRepositoryInterface::class);
        $this->categoryRepository = Mockery::mock(CategoryRepositoryInterface::class);
        $this->productCategoryRepository = Mockery::mock(ProductCategoryRepositoryInterface::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        Mockery::close();
    }
}
