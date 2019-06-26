<?php

namespace App\BL;


use App\Entity\Possession;
use App\Entity\PossessionType;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;

/**
 * Class PossessionTypeManager
 * @package App\BL
 */
class PossessionTypeManager
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * PossessionTypeManager constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return array
     */
    public function getAllPossessionTypes(): array 
    {
        return $this->entityManager->getRepository(PossessionType::class)->findAll();
    }
}
