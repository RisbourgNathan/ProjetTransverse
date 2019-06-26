<?php

namespace App\DAL;


use App\Entity\PossessionType;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class PossessionTypeCrud
 * @package App\DAL
 */
class PossessionTypeCrud
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * PossessionTypeCrud constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param PossessionType $possessionType
     */
    public function createPossessionType(PossessionType $possessionType)
    {
        $this->entityManager->persist($possessionType);
        $this->entityManager->flush();
    }

}
