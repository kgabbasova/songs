<?php

namespace App\Repository;

use App\Entity\SongDislikes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SongDislikes|null find($id, $lockMode = null, $lockVersion = null)
 * @method SongDislikes|null findOneBy(array $criteria, array $orderBy = null)
 * @method SongDislikes[]    findAll()
 * @method SongDislikes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SongDislikesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SongDislikes::class);
    }

    // /**
    //  * @return SongDislikes[] Returns an array of SongDislikes objects
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
    public function findOneBySomeField($value): ?SongDislikes
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
