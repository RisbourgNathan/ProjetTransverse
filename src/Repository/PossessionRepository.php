<?php

namespace App\Repository;

use App\Entity\Possession;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method Possession|null find($id, $lockMode = null, $lockVersion = null)
 * @method Possession|null findOneBy(array $criteria, array $orderBy = null)
 * @method Possession[]    findAll()
 * @method Possession[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PossessionRepository extends ServiceEntityRepository
{
    private $knp;
    private $em;
    public function __construct(RegistryInterface $registry, PaginatorInterface $knp, EntityManagerInterface $em)
    {
        parent::__construct($registry, Possession::class);
        $this->knp = $knp;
        $this->em = $em;
    }

    public function findBySearch($city, $price, $array_id, Request $request)
    {
        $dql   = "SELECT p FROM App\Entity\Possession p
                      WHERE p.sellingPrice < :price
                      AND p.city LIKE :city
                      AND p.type IN (:type_id)";
        $query = $this->em->createQuery($dql)
            ->setParameter('price', $price)
            ->setParameter('city', "%$city%")
            ->setParameter('type_id', $array_id);
        $possessions = $this->knp->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            9 /*limit per page*/
        );
        return $possessions;
    }

    public function findByCity(Request $request, $city){
        $dql   = "SELECT p FROM App\Entity\Possession p
                      WHERE p.city LIKE :city";
        $query = $this->em->createQuery($dql)
            ->setParameter('city', "%$city%");
        $possessions = $this->knp->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            9 /*limit per page*/
        );
        return $possessions;
    }

    public function findAllPossessions(Request $request){
        $dql   = "SELECT p FROM App\Entity\Possession p";
        $query = $this->em->createQuery($dql);
        $possessions = $this->knp->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            9 /*limit per page*/
        );
        return $possessions;
    }
}
