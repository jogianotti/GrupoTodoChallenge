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
        $result = [
            ['id' => 1, 'parent' => 0, 'name' => 'one'],
            ['id' => 2, 'parent' => 1, 'name' => 'two'],
            ['id' => 3, 'parent' => 0, 'name' => 'three'],
            ['id' => 4, 'parent' => 3, 'name' => 'four'],
        ];

        $this->categoryRepository
            ->shouldReceive('allParents')
            ->once()
            ->andReturn($result);

        $menu = (new MenuMaker($this->categoryRepository))();

        self::assertIsArray($menu);
        self::assertEquals('one', $menu[0]['name']);
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
