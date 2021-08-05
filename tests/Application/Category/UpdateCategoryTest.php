<?php declare(strict_types=1);

namespace App\Tests\Application\Category;

use App\Application\Category\CategoryUpdater;
use App\Repository\CategoryRepositoryInterface;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

final class UpdateCategoryTest extends TestCase
{

    /**
     * @var CategoryRepositoryInterface|MockInterface
     */
    private $categoryRepository;

    /** @doesNotPerformAssertions */
    public function testItShouldUpdateCategory(): void
    {
        $id = 1;
        $category = CategoryMother::create();

        $this->categoryRepository
            ->shouldReceive('one')
            ->with($id)
            ->once()
            ->andReturn($category);

        $this->categoryRepository
            ->shouldReceive('save')
            ->with($category)
            ->once();

        (new CategoryUpdater($this->categoryRepository))(
            $id,
            $category->getName(),
            $category->getDescription(),
            $category->getParent()
        );
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
