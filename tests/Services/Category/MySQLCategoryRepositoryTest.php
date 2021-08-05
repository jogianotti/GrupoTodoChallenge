<?php declare(strict_types=1);

namespace App\Tests\Services\Category;

use App\Entity\Categoria;
use App\Repository\CategoriaRepository;
use App\Tests\Application\Category\CategoryMother;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


final class MySQLCategoryRepositoryTest extends KernelTestCase
{
    private CategoriaRepository $categoryRepository;

    public function testItShouldSaveCategory(): void
    {
        $category = CategoryMother::create();

        $this->categoryRepository->save($category);
        $saved = $this->categoryRepository->find($category->getId());

        self::assertEquals($category, $saved);
    }

    public function testItShouldGetAllCategories()
    {
        $this->categoryRepository->save(CategoryMother::create());

        $categories = $this->categoryRepository->all();

        self::assertIsArray($categories);
        self::assertInstanceOf(Categoria::class, $categories[0]);
    }

    protected function setUp(): void
    {
        self::bootKernel();
        $container = self::$container;

        /** @var ManagerRegistry $managerRegistry */
        $managerRegistry = $container->get(ManagerRegistry::class);

        $this->categoryRepository = new CategoriaRepository($managerRegistry);
    }
}
