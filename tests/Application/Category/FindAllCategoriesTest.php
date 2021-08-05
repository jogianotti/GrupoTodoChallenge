<?php declare(strict_types=1);

namespace App\Tests\Application\Category;

use App\Application\Category\AllCategoriesFinder;
use App\Repository\CategoryRepositoryInterface;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

final class FindAllCategoriesTest extends TestCase
{
    /**
     * @var CategoryRepositoryInterface|MockInterface
     */
    private $categoryRepository;

    public function testItShouldFindAllCategories()
    {
        $this->categoryRepository
            ->shouldReceive('all')
            ->once()
            ->andReturn([]);

        $categories = (new AllCategoriesFinder($this->categoryRepository))();

        self::assertIsArray($categories);
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
