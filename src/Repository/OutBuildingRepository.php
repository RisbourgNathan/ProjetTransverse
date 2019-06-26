<?php

namespace App\Repository;

use App\Entity\OutBuilding;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method OutBuilding|null find($id, $lockMode = null, $lockVersion = null)
 * @method OutBuilding|null findOneBy(array $criteria, array $orderBy = null)
 * @method OutBuilding[]    findAll()
 * @method OutBuilding[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

/**
 * Class OutBuildingRepository
 * @package App\Repository
 */
class OutBuildingRepository extends ServiceEntityRepository
{
    /**
     * OutBuildingRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, OutBuilding::class);
    }

    // /**
    //  * @return OutBuilding[] Returns an array of OutBuilding objects
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
    public function findOneBySomeField($value): ?OutBuilding
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
