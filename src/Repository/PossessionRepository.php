<?php

namespace App\Repository;

use App\Entity\Possession;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method Possession|null find($id, $lockMode = null, $lockVersion = null)
 * @method Possession|null findOneBy(array $criteria, array $orderBy = null)
 * @method Possession[]    findAll()
 * @method Possession[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

/**
 * Class PossessionRepository
 * @package App\Repository
 */
class PossessionRepository extends ServiceEntityRepository
{
    /**
     * @var PaginatorInterface
     */
    private $knp;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * PossessionRepository constructor.
     * @param RegistryInterface $registry
     * @param PaginatorInterface $knp
     * @param EntityManagerInterface $em
     */
    public function __construct(RegistryInterface $registry, PaginatorInterface $knp, EntityManagerInterface $em)
    {
        parent::__construct($registry, Possession::class);
        $this->knp = $knp;
        $this->em = $em;
    }

    /**
     * @param $city
     * @param $price
     * @param $array_id
     * @param Request $request
     * @return PaginationInterface
     */
    public function findBySearch($city, $price, $array_id, Request $request)
    {
        $dql   = "SELECT p FROM App\Entity\Possession p
                      WHERE p.sellingPrice < :price
                      AND p.city LIKE :city
                      AND p.type IN (:type_id)
                      AND p.validationState = :validState";
        $query = $this->em->createQuery($dql)
            ->setParameter('price', $price)
            ->setParameter('city', "%$city%")
            ->setParameter('type_id', $array_id)
            ->setParameter('validState', "SELL");
        $possessions = $this->knp->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            9 /*limit per page*/
        );
        return $possessions;
    }

    /**
     * @param Request $request
     * @param $city
     * @return PaginationInterface
     */
    public function findByCity(Request $request, $city){
        $dql   = "SELECT p FROM App\Entity\Possession p
                      WHERE p.city LIKE :city
                      AND p.validationState = 'SELL'";
        $query = $this->em->createQuery($dql)
            ->setParameter('city', "%$city%");
        $possessions = $this->knp->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            9 /*limit per page*/
        );
        return $possessions;
    }

    /**
     * @param Request $request
     * @return PaginationInterface
     */
    public function findAllPossessions(Request $request){
        $dql   = "SELECT p FROM App\Entity\Possession p WHERE p.validationState != 'SOLD'";
        $query = $this->em->createQuery($dql);
        $possessions = $this->knp->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            9 /*limit per page*/
        );
        return $possessions;
    }
}
