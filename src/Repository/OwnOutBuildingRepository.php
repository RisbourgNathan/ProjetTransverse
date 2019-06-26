<?php

namespace App\Repository;

use App\Entity\OwnOutBuilding;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method OwnOutBuilding|null find($id, $lockMode = null, $lockVersion = null)
 * @method OwnOutBuilding|null findOneBy(array $criteria, array $orderBy = null)
 * @method OwnOutBuilding[]    findAll()
 * @method OwnOutBuilding[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

/**
 * Class OwnOutBuildingRepository
 * @package App\Repository
 */
class OwnOutBuildingRepository extends ServiceEntityRepository
{
    /**
     * OwnOutBuildingRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, OwnOutBuilding::class);
    }

    // /**
    //  * @return OwnOutBuilding[] Returns an array of OwnOutBuilding objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OwnOutBuilding
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
