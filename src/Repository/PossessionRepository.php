<?php

namespace App\Repository;

use App\Entity\Possession;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\DBALException;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Possession|null find($id, $lockMode = null, $lockVersion = null)
 * @method Possession|null findOneBy(array $criteria, array $orderBy = null)
 * @method Possession[]    findAll()
 * @method Possession[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PossessionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Possession::class);
    }

    public function findBySearch($city, $price, $array_id)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery('
        SELECT p FROM App\Entity\Possession p
        WHERE p.sellingPrice < :price
        AND p.city LIKE :city
        AND p.type IN (:type_id)
        ')
        ->setParameter('price', $price)
        ->setParameter('city', "%$city%")
        ->setParameter('type_id', $array_id);
        return $query->execute();
    }
}
