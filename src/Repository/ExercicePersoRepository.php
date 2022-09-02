<?php

namespace App\Repository;

use App\Entity\ExercicePerso;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ExercicePerso>
 *
 * @method ExercicePerso|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExercicePerso|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExercicePerso[]    findAll()
 * @method ExercicePerso[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExercicePersoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExercicePerso::class);
    }

    public function add(ExercicePerso $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ExercicePerso $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ExercicePerso[] Returns an array of ExercicePerso objects
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

//    public function findOneBySomeField($value): ?ExercicePerso
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
