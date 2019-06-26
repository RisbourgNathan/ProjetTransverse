<?php

namespace App\BL;


use App\Entity\OutBuilding;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class OutbuildingManager
 * @package App\BL
 */
class OutbuildingManager
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * OutbuildingManager constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return \App\Entity\Administrator[]|\App\Entity\Agency[]|\App\Entity\AgencyDirector[]|\App\Entity\Client[]|OutBuilding[]|object[]
     */
    public function getAllOutbuildings()
    {
        return $this->entityManager->getRepository(OutBuilding::class)->findAll();
    }
}
