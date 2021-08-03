<?php declare(strict_types=1);

namespace App\Tests\Application\Category;

use App\Application\Category\CategoryCreator;
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

        $this->categoryRepository
            ->shouldReceive('save')
            ->with(Matchers::equalTo($category))
            ->once();

        $name = $category->getName();
        $parent = ($category->getParent()) ? $category->getParent()->getId() : null;
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
