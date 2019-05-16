<?php

namespace App\Repository;

use App\Entity\SongLike;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SongLike|null find($id, $lockMode = null, $lockVersion = null)
 * @method SongLike|null findOneBy(array $criteria, array $orderBy = null)
 * @method SongLike[]    findAll()
 * @method SongLike[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SongLikeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SongLike::class);
    }

    // /**
    //  * @return SongLike[] Returns an array of SongLike objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SongLike
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

}
