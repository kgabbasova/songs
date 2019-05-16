<?php

namespace App\Repository;

use App\Entity\Song;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use phpDocumentor\Reflection\Types\This;
use phpDocumentor\Reflection\Types\Void_;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Song|null find($id, $lockMode = null, $lockVersion = null)
 * @method Song|null findOneBy(array $criteria, array $orderBy = null)
 * @method Song[]    findAll()
 * @method Song[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */


class SongRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Song::class);
    }

    // /**
    //  * @return Song[] Returns an array of Song objects
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
    public function findOneBySomeField($value): ?Song
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function incrementSongLike(Song $song)
    {
        $q = $this->createQueryBuilder('s')->update()
            ->set('s.likesAmount', $song->getLikesAmount() + 1)
            ->where('s.id = ?1')
            ->setParameter(1, $song->getId())
            ->getQuery();
        return $q->execute();
    }

    public function incrementSongDislike(Song $song)
    {
        $q = $this->createQueryBuilder('s')->update()
            ->set('s.dislikesAmount', $song->getDislikesAmount() + 1)
            ->where('s.id = ?1')
            ->setParameter(1, $song->getId())
            ->getQuery();
        return $q->execute();
    }

    public function decrementSongLike(Song $song)
    {
        $q = $this->createQueryBuilder('s')->update()
            ->set('s.likesAmount', $song->getLikesAmount() - 1)
            ->where('s.id = ?1')
            ->setParameter(1, $song->getId())
            ->getQuery();
        return $q->execute();
    }


    public function decrementSongDislike(Song $song)
    {
        $q = $this->createQueryBuilder('s')->update()
            ->set('s.dislikesAmount', $song->getDislikesAmount() - 1)
            ->where('s.id = ?1')
            ->setParameter(1, $song->getId())
            ->getQuery();
        return $q->execute();
    }


}
