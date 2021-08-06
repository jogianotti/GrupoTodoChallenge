<?php declare(strict_types=1);

namespace App\Tests\Services\Product;

use App\Entity\Producto;
use App\Repository\ProductoRepository;
use App\Tests\Application\Product\ProductMother;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class MySQLProductRepositoryTest extends KernelTestCase
{
    private ProductoRepository $productRepository;

    public function testItShouldSaveAProduct(): void
    {
        $product = ProductMother::create();

        $this->productRepository->save($product);
//        (self::$container->get(EntityManagerInterface::class))->clear();

        $saved = $this->productRepository->find($product->getId());

        self::assertEquals($product, $saved);
    }

    public function testItShouldGetAllProducts(): void
    {
        $this->productRepository->save(ProductMother::create());

        $categories = $this->productRepository->all();

        self::assertIsArray($categories);
        self::assertInstanceOf(Producto::class, $categories[0]);
    }

    protected function setUp(): void
    {
        self::bootKernel();
        $container = self::$container;

        /** @var ManagerRegistry $managerRegistry */
        $managerRegistry = $container->get(ManagerRegistry::class);

        $this->productRepository = new ProductoRepository($managerRegistry);
    }
}
