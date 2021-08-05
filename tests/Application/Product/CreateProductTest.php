<?php declare(strict_types=1);

namespace App\Tests\Application\Product;

use App\Application\Category\CategoryFinder;
use App\Application\Product\ProductCreator;
use App\Repository\CategoryRepositoryInterface;
use App\Repository\ProductRepositoryInterface;
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

    /** @doesNotPerformAssertions */
    public function testItShouldCreateAProduct()
    {
        $product = ProductMother::create();
        $category_id = 1;

        $this->categoryRepository
            ->shouldReceive('one')
            ->with($category_id)
            ->once()
            ->andReturn($product->getCategory());

        $this->productRepository
            ->shouldReceive('save')
            ->with(Matchers::equalTo($product))
            ->once();

        (new ProductCreator($this->productRepository, new CategoryFinder($this->categoryRepository)))(
            $product->getName(),
            $category_id
        );
    }

    protected function setUp(): void
    {
        $this->productRepository = Mockery::mock(ProductRepositoryInterface::class);
        $this->categoryRepository = Mockery::mock(CategoryRepositoryInterface::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        Mockery::close();
    }
}
