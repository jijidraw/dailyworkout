<?php

namespace App\Repository;

use App\Entity\Workout;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Workout>
 *
 * @method Workout|null find($id, $lockMode = null, $lockVersion = null)
 * @method Workout|null findOneBy(array $criteria, array $orderBy = null)
 * @method Workout[]    findAll()
 * @method Workout[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkoutRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Workout::class);
    }

    public function add(Workout $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Workout $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function searchByMuscle($muscle)
    {
        $query = $this->createQueryBuilder('w');
        $query->leftJoin('w.muscleGroup', 'm');
        $query->where('m.id = :id')
            ->setParameter('id', $muscle);
        return $query->getQuery()->getResult();
    }
    public function searchBySport($sport)
    {
        $query = $this->createQueryBuilder('w');
        $query->leftJoin('w.sport', 's');
        $query->where('s.id = :id')
            ->setParameter('id', $sport);
        return $query->getQuery()->getResult();
    }
    public function searchByUser($user)
    {
        $query = $this->createQueryBuilder('w');
        $query->leftJoin('w.user', 'u');
        $query->where('u.id = :id')
            ->setParameter('id', $user);
        return $query->getQuery()->getResult();
    }

    //    /**
    //     * @return Workout[] Returns an array of Workout objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('w')
    //            ->andWhere('w.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('w.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Workout
    //    {
    //        return $this->createQueryBuilder('w')
    //            ->andWhere('w.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
