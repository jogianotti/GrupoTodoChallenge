<?php declare(strict_types=1);

namespace App\Tests\Application\Category;

use App\Application\Category\CategoryRemover;
use App\Repository\CategoryRepositoryInterface;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

final class RemoveCategoryTest extends TestCase
{
    /**
     * @var CategoryRepositoryInterface|MockInterface
     */
    private $categoryRepository;

    /** @doesNotPerformAssertions */
    public function testItShouldRemoveACategory(): void
    {
        $id = 1;
        $category = CategoryMother::create();

        $this->categoryRepository
            ->shouldReceive('one')
            ->with($id)
            ->once()
            ->andReturn($category);

        $this->categoryRepository
            ->shouldReceive('remove')
            ->with($category)
            ->once();

        (new CategoryRemover($this->categoryRepository))($id);

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
