<?php

namespace App\Repository;

use App\Entity\AgencyDirector;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AgencyDirector|null find($id, $lockMode = null, $lockVersion = null)
 * @method AgencyDirector|null findOneBy(array $criteria, array $orderBy = null)
 * @method AgencyDirector[]    findAll()
 * @method AgencyDirector[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AgencyDirectorRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AgencyDirector::class);
    }

    // /**
    //  * @return AgencyDirector[] Returns an array of AgencyDirector objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AgencyDirector
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
