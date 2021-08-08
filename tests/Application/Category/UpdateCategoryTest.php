<?php declare(strict_types=1);

namespace App\Tests\Application\Category;

use App\Application\Category\CategoryUpdater;
use App\Entity\Categoria;
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
        $parent_id = 2;
        $parent = new Categoria($parent_id);

        $this->categoryRepository
            ->shouldReceive('one')
            ->with($parent_id)
            ->once()
            ->andReturn($parent);

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
            $parent->getId()
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
