<?php declare(strict_types=1);

namespace App\Tests\Application\Category;

use App\Application\Category\CategoryUpdater;
use App\Entity\Categoria;
use App\Message\CategoryUpdatedMessage;
use App\Repository\CategoryRepositoryInterface;
use Hamcrest\Matchers;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

final class UpdateCategoryTest extends TestCase
{

    /**
     * @var CategoryRepositoryInterface|MockInterface
     */
    private $categoryRepository;
    /**
     * @var MockInterface|MessageBusInterface
     */
    private $bus;

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

        $message = new CategoryUpdatedMessage($id);

        $this->bus
            ->shouldReceive('dispatch')
            ->with(Matchers::equalTo($message))
            ->once()
            ->andReturn(new Envelope($message));

        (new CategoryUpdater($this->categoryRepository, $this->bus))(
            $id,
            $category->getName(),
            $category->getDescription(),
            $parent->getId()
        );
    }

    protected function setUp(): void
    {
        $this->categoryRepository = Mockery::mock(CategoryRepositoryInterface::class);
        $this->bus = Mockery::mock(MessageBusInterface::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        Mockery::close();
    }
}
