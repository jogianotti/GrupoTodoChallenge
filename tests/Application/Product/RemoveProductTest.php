<?php declare(strict_types=1);

namespace App\Tests\Application\Product;

use App\Application\Product\ProductRemover;
use App\Repository\ProductRepositoryInterface;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

final class RemoveProductTest extends TestCase
{
    /**
     * @var ProductRepositoryInterface|MockInterface
     */
    private $productRepository;

    /** @doesNotPerformAssertions */
    public function testItShouldRemoveAProduct(): void
    {
        $id = 1;
        $product = ProductMother::create();

        $this->productRepository
            ->shouldReceive('one')
            ->with($id)
            ->once()
            ->andReturn($product);

        $this->productRepository
            ->shouldReceive('remove')
            ->with($product)
            ->once();

        (new ProductRemover($this->productRepository))($id);
    }

    protected function setUp(): void
    {
        $this->productRepository = Mockery::mock(ProductRepositoryInterface::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        Mockery::close();
    }
}
