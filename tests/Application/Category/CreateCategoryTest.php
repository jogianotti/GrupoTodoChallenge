<?php declare(strict_types=1);

namespace App\Tests\Application\Category;

use App\Application\Category\CategoryCreator;
use App\Entity\Categoria;
use App\Repository\CategoryRepositoryInterface;
use Hamcrest\Matchers;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

final class CreateCategoryTest extends TestCase
{
    /**
     * @var MockInterface|CategoryRepositoryInterface
     */
    private $categoryRepository;

    /** @doesNotPerformAssertions */
    public function testItShouldCreateCategory()
    {
        $category = CategoryMother::create();
        $parent_id = 1;
        $parent = new Categoria($parent_id);
        $category->setParent($parent);

        $this->categoryRepository
            ->shouldReceive('one')
            ->with(1)
            ->once()
            ->andReturn($parent);

        $this->categoryRepository
            ->shouldReceive('save')
            ->with(Matchers::equalTo($category))
            ->once();

        $name = $category->getName();
        $parent = $parent->getId();
        $description = $category->getDescription();

        (new CategoryCreator($this->categoryRepository))($name, $description, $parent);
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
