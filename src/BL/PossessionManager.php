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

class PossessionManager
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
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

}