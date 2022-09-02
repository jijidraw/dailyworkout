<?php

namespace App\Repository;

use App\Entity\ChallengePlayer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ChallengePlayer>
 *
 * @method ChallengePlayer|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChallengePlayer|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChallengePlayer[]    findAll()
 * @method ChallengePlayer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChallengePlayerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChallengePlayer::class);
    }

    public function add(ChallengePlayer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ChallengePlayer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findChallengers($challenge)
    {
        $query = $this->createQueryBuilder('c');
        $query->leftJoin('c.challenge', 'cc');
        $query->where('cc.id = :id')
            ->setParameter('id', $challenge)
            ->andWhere('c.is_challenged = 1');
        return $query->getQuery()->getResult();
    }
    public function findAccomplish($challenge)
    {
        $query = $this->createQueryBuilder('c');
        $query->leftJoin('c.challenge', 'cc');
        $query->where('cc.id = :id')
            ->setParameter('id', $challenge)
            ->andWhere('c.is_accomplish = 1');
        return $query->getQuery()->getResult();
    }
    public function findInvited($challenge)
    {
        $query = $this->createQueryBuilder('c');
        $query->leftJoin('c.challenge', 'cc');
        $query->where('cc.id = :id')
            ->setParameter('id', $challenge)
            ->andWhere('c.is_invite = 1');
        return $query->getQuery()->getResult();
    }

    //    /**
    //     * @return ChallengePlayer[] Returns an array of ChallengePlayer objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?ChallengePlayer
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
