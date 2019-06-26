<?php

namespace App\Repository;

use App\Entity\PossessionType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PossessionType|null find($id, $lockMode = null, $lockVersion = null)
 * @method PossessionType|null findOneBy(array $criteria, array $orderBy = null)
 * @method PossessionType[]    findAll()
 * @method PossessionType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

/**
 * Class PossessionTypeRepository
 * @package App\Repository
 */
class PossessionTypeRepository extends ServiceEntityRepository
{
    /**
     * PossessionTypeRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PossessionType::class);
    }

    // /**
    //  * @return PossessionType[] Returns an array of PossessionType objects
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
    public function findOneBySomeField($value): ?PossessionType
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
