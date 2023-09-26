<?php

namespace App\Repository;

use App\Entity\LivreUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LivreUser>
 *
 * @method LivreUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method LivreUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method LivreUser[]    findAll()
 * @method LivreUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivreUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LivreUser::class);
    }

//    /**
//     * @return LivreUser[] Returns an array of LivreUser objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?LivreUser
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
