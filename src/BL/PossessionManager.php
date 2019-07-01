<?php
/**
 * Created by PhpStorm.
 * User: NathanR
 * Date: 12/21/2018
 * Time: 3:50 PM
 */

namespace App\BL;


use App\Entity\Possession;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PossessionRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PossessionManager
 * @package App\BL
 */
class PossessionManager
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var RegistryInterface
     */
    private $registry;
    /**
     * @var PaginatorInterface
     */
    private $knp;

    /**
     * PossessionManager constructor.
     * @param EntityManagerInterface $entityManager
     * @param RegistryInterface $registry
     * @param PaginatorInterface $knp
     */
    public function __construct(EntityManagerInterface $entityManager, RegistryInterface $registry, PaginatorInterface $knp)
    {
        $this->entityManager = $entityManager;
        $this->registry = $registry;
        $this->knp = $knp;
    }

    /**
     * @param Request $request
     * @return PaginationInterface
     */
    public function getAllPossessions(Request $request)
    {
        $repository = new PossessionRepository($this->registry, $this->knp, $this->entityManager);
        $possessions = $repository->findAllPossessions($request);
        return $possessions;
    }

    /**
     * @param $possessionType
     * @return Possession[]|object[]
     */
    public function getPossessionsFromTypeId($possessionType)
    {
        return $this->entityManager->getRepository(Possession::class)->findBy(array('type' => $possessionType));
    }

    /**
     * @param $city
     * @param Request $request
     * @return PaginationInterface
     */
    public function getPossessionsByName($city, Request $request)
    {
        $repository = new PossessionRepository($this->registry, $this->knp, $this->entityManager);
        $possessions = $repository->findByCity($request, $city);
        return $possessions;
    }

    /**
     * @param $city
     * @param $price
     * @param $type_id
     * @param Request $request
     * @return PaginationInterface
     */
    public function getPossessionsBySearch($city, $price, $type_id, Request $request)
    {
         $repository = new PossessionRepository($this->registry, $this->knp, $this->entityManager);
         $possessions = $repository->findBySearch($city, $price, $type_id, $request);
         return $possessions;
    }

    /**
     * @param $id
     * @return Possession
     */
    public function getPossessionById($id): Possession
    {
        return $this->entityManager->getRepository(Possession::class)->find($id);
    }

    /**
     * @return Possession[]|object[]
     */
    public function getLatestPossessions(){
        return $this->entityManager->getRepository(Possession::class)->findBy(array("validationState" => 'SELL'), array('createdAt' => 'DESC'), 3);
    }

    /**
     * @param $possession
     */
    public function savePossession($possession)
    {
        $this->entityManager->persist($possession);
        $this->entityManager->flush();
    }

    /**
     * @return Possession[]|array|object[]
     */
    public function getListPossessions(){
        return $this->entityManager->getRepository(Possession::class)->findAll();
    }
}
