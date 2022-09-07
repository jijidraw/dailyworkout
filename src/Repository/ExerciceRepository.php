<?php

namespace App\Repository;

use App\Entity\Exercice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Exercice>
 *
 * @method Exercice|null find($id, $lockMode = null, $lockVersion = null)
 * @method Exercice|null findOneBy(array $criteria, array $orderBy = null)
 * @method Exercice[]    findAll()
 * @method Exercice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExerciceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Exercice::class);
    }

    public function add(Exercice $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Exercice $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    // système pour trouver des exercices par catégories

    public function searchByCategory($category)
    {
        $query = $this->createQueryBuilder('e');
        $query->leftJoin('e.categories', 'c');
        $query->where('c.id = :id')
            ->setParameter('id', $category);
        return $query->getQuery()->getResult();
    }
    public function searchByMuscle($muscle)
    {
        $query = $this->createQueryBuilder('e');
        $query->leftJoin('e.muscleGroup', 'm');
        $query->where('m.id = :id')
            ->setParameter('id', $muscle);
        return $query->getQuery()->getResult();
    }
    public function searchBySport($sport)
    {
        $query = $this->createQueryBuilder('e');
        $query->leftJoin('e.sports', 's');
        $query->where('s.id = :id')
            ->setParameter('id', $sport);
        return $query->getQuery()->getResult();
    }



    //    /**
    //     * @return Exercice[] Returns an array of Exercice objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Exercice
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
