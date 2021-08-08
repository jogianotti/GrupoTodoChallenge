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

    public function testItShouldGetAllCategories(): void
    {
        $this->categoryRepository->save(CategoryMother::create());

        $categories = $this->categoryRepository->all();

        self::assertIsArray($categories);
        self::assertInstanceOf(Categoria::class, $categories[0]);
    }

    public function testItShouldGetACategory(): void
    {
        $searchedCategory = CategoryMother::create();
        $this->categoryRepository->save($searchedCategory);

        $category = $this->categoryRepository->one($searchedCategory->getId());

        self::assertEquals($searchedCategory, $category);
    }

    public function testItShouldRemoveACategory()
    {
        $category = CategoryMother::create();
        $this->categoryRepository->save($category);
        $id = $category->getId();

        $saved = $this->categoryRepository->one($id);

        self::assertEquals($category, $saved);

        $this->categoryRepository->remove($category);

        $deleted = $this->categoryRepository->one($id);

        self::assertNull($deleted);
    }

    public function testItShouldGetAllParentsCategories(): void
    {
        $category = CategoryMother::create();
        $this->categoryRepository->save($category);

        $categories = $this->categoryRepository->allParents();

        self::assertContains([
            'id' => (string)$category->getId(),
            'parent' => "0",
            'name' => $category->getName()
        ], $categories);
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
