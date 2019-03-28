<?php

namespace App\Repository;

use App\Entity\PossessionImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PossessionImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method PossessionImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method PossessionImage[]    findAll()
 * @method PossessionImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PossessionImageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PossessionImage::class);
    }

    // /**
    //  * @return PossessionImage[] Returns an array of PossessionImage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PossessionImage
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
