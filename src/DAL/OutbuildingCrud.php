<?php

namespace App\DAL;


use App\Entity\OutBuilding;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class OutbuildingCrud
 * @package App\DAL
 */
class OutbuildingCrud
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * OutbuildingCrud constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param OutBuilding $outbuilding
     */
    public function createOutbuilding(Outbuilding $outbuilding)
    {
        $this->entityManager->persist($outbuilding);
        $this->entityManager->flush();
    }
}
