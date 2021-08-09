<?php

namespace App\Repository;

use App\Entity\Categoria;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Categoria|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categoria|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categoria[]    findAll()
 * @method Categoria[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoriaRepository extends ServiceEntityRepository implements CategoryRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categoria::class);
    }

    public function save(Categoria $category): void
    {
        $entityManager = $this->getEntityManager();

        $entityManager->persist($category);
        $entityManager->flush();
    }

    public function all(): array
    {
        return $this->findAll();
    }

    public function one(int $id): ?Categoria
    {
        return $this->find($id);
    }

    public function remove(Categoria $category): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->remove($category);
        $entityManager->flush();
    }

    public function allParents(): array
    {
        $sql = "SELECT id, IFNULL(parent_id, 0) as parent, nombre as name FROM categorias";


        return $this->getEntityManager()
            ->getConnection()
            ->prepare($sql)
            ->executeQuery()
            ->fetchAllAssociative();
    }

    public function allChildren(array $ids): array
    {
        return $this->createQueryBuilder('c')
            ->where('c.parent IN (:parents)')
            ->setParameter('parents', $ids)
            ->getQuery()
            ->getResult();
    }

    public function saveAll(array $categories): void
    {
        $entityManager = $this->getEntityManager();

        foreach ($categories as $category) {
            $entityManager->persist($category);
        }

        $entityManager->flush();
    }
}
