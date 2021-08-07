<?php

namespace App\Repository;

use App\Entity\Producto;
use App\Entity\ProductoCategoria;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProductoCategoria|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductoCategoria|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductoCategoria[]    findAll()
 * @method ProductoCategoria[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductoCategoriaRepository extends ServiceEntityRepository implements ProductCategoryRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductoCategoria::class);
    }

    public function save(ProductoCategoria $productCategory)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($productCategory);
        $entityManager->flush();
    }

    public function oneByProduct(Producto $product): ProductoCategoria
    {
        return $this->findOneBy(['product' => $product]);
    }

    public function remove(ProductoCategoria $productCategory): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->remove($productCategory);
        $entityManager->flush();
    }
}
