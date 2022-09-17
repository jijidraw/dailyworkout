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

    public function workoutFilters($fMuscles = null, $fSports = null, $fDifficulties = null)
    {
        $query = $this->createQueryBuilder('w');

        if ($fMuscles != null) {
            $query->leftJoin('w.muscleGroup', 'm');
            $query->andWhere('m.id = :id')
                ->setParameter('id', array_values($fMuscles));
            // $query->andWhere('e.muscleGroup IN(:muscles)')
            //     ->setParameter(':muscles', array_values($fMuscles));
        }
        if ($fSports != null) {
            $query->leftJoin('w.sport', 's');
            $query->andWhere('s.id = :id')
                ->setParameter('id', array_values($fSports));
            // $query->andWhere('e.sports IN(:sports)')
            //     ->setParameter(':sports', array_values($fSports));
        }
        if ($fDifficulties != null) {
            $query->leftJoin('w.level', 'l');
            $query->andWhere('l.id = :id')
                ->setParameter('id', array_values($fDifficulties));
            // $query->andWhere('w.level IN(:level)')
            //     ->setParameter(':level', array_values($fDifficulties));
        }
        $query->setMaxResults(20);
        $query->orderBy('w.id', 'DESC');
        return $query->getQuery()->getResult();
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
