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
use Symfony\Bridge\Doctrine\RegistryInterface;

class PossessionManager
{
    private $entityManager;
    private $registry;

    public function __construct(EntityManagerInterface $entityManager, RegistryInterface $registry)
    {
        $this->entityManager = $entityManager;
        $this->registry = $registry;
    }

    /**
     * @return Possession[]|object[]
     */
    public function getAllPossessions()
    {
        return $this->entityManager->getRepository(Possession::class)->findAll();
    }

    public function getPossessionsFromTypeId($possessionType)
    {
        return $this->entityManager->getRepository(Possession::class)->findBy(array('type' => $possessionType));
    }
    public function getPossessionsByName($city)
    {
        return $this->entityManager->getRepository(Possession::class)->findBy(array('city' => $city));
    }
    public function getPossessionsBySearch($city, $price, $type_id)
    {
         $repository = new PossessionRepository($this->registry);
         return $repository->findBySearch($city, $price, $type_id);
    }

    public function getPossessionById($id): Possession
    {
        return $this->entityManager->getRepository(Possession::class)->find($id);
    }
}
