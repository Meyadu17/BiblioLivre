<?php

namespace App\Repository;

use App\Entity\LivreBibliotheque;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LivreBibliotheque>
 *
 * @method LivreBibliotheque|null find($id, $lockMode = null, $lockVersion = null)
 * @method LivreBibliotheque|null findOneBy(array $criteria, array $orderBy = null)
 * @method LivreBibliotheque[]    findAll()
 * @method LivreBibliotheque[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivreBibliothequeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LivreBibliotheque::class);
    }

//    /**
//     * @return LivreBibliotheque[] Returns an array of LivreBibliotheque objects
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

//    public function findOneBySomeField($value): ?LivreBibliotheque
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
