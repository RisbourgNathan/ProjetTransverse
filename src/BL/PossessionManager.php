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
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Request;

class PossessionManager
{
    private $entityManager;
    private $registry;
    private $knp;

    public function __construct(EntityManagerInterface $entityManager, RegistryInterface $registry, PaginatorInterface $knp)
    {
        $this->entityManager = $entityManager;
        $this->registry = $registry;
        $this->knp = $knp;
    }

    /**
     * @param Request $request
     * @return Possession[]|object[]
     */
    public function getAllPossessions(Request $request)
    {
        $repository = new PossessionRepository($this->registry, $this->knp, $this->entityManager);
        $possessions = $repository->findAllPossessions($request);
        return $possessions;
    }

    public function getPossessionsFromTypeId($possessionType)
    {
        return $this->entityManager->getRepository(Possession::class)->findBy(array('type' => $possessionType));
    }
    public function getPossessionsByName($city)
    {
        return $this->entityManager->getRepository(Possession::class)->findBy(array('city' => $city));
    }
    public function getPossessionsBySearch($city, $price, $type_id, Request $request)
    {
         $repository = new PossessionRepository($this->registry, $this->knp, $this->entityManager);
         $possessions = $repository->findBySearch($city, $price, $type_id, $request);
         return $possessions;
    }

    public function getPossessionById($id): Possession
    {
        return $this->entityManager->getRepository(Possession::class)->find($id);
    }

    public function getLatestPossessions(){
        return $this->entityManager->getRepository(Possession::class)->findBy(array(), array('createdAt' => 'ASC'), 3);
    }

    public function savePossession($possession)
    {
        $this->entityManager->persist($possession);
        $this->entityManager->flush();
    }
}
