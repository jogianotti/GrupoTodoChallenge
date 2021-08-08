<?php declare(strict_types=1);

namespace App\Tests\Application\Category;

use App\Application\Category\MenuMaker;
use App\Repository\CategoryRepositoryInterface;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

final class GetMenuTest extends TestCase
{
    /**
     * @var CategoryRepositoryInterface|MockInterface
     */
    private $categoryRepository;

    public function testItShouldGenerateTheCategoriesMenu()
    {
        $ca = CategoryMother::create();
        $cb = CategoryMother::create();
        $cc = CategoryMother::create();
        $cd = CategoryMother::create();

        $cb->setParent($ca);
        $cd->setParent($cc);

        $this->categoryRepository
            ->shouldReceive('allParents')
            ->once()
            ->andReturn([$ca, $cc]);

        $menu = (new MenuMaker($this->categoryRepository))();

        self::assertIsArray($menu);
        self::assertEquals($ca->getName(), $menu[0]['name']);
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
