<?php declare(strict_types=1);

namespace App\Tests\Application\Category;

use App\Application\Category\CategoryFinder;
use App\Entity\Categoria;
use App\Repository\CategoryRepositoryInterface;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

final class FindACategoryTest extends TestCase
{
    /**
     * @var CategoryRepositoryInterface|MockInterface
     */
    private $categoryRepository;

    public function testItShouldFindACategory(): void
    {
        $id = 1;
        $searchedCategory = new Categoria();

        $this->categoryRepository
            ->shouldReceive('one')
            ->with($id)
            ->once()
            ->andReturn($searchedCategory);

        $category = (new CategoryFinder($this->categoryRepository))($id);

        self::assertInstanceOf(Categoria::class, $category);
        self::assertEquals($searchedCategory, $category);
    }

    protected function setUp(): void
    {
        $this->categoryRepository = Mockery::mock(CategoryRepositoryInterface::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        Mockery::close();
    }
}
