<?php
/**
 * Created by IntelliJ IDEA.
 * User: RAGOSTINI
 * Date: 19/12/2018
 * Time: 15:46
 */

namespace App\DAL;
use App\Entity\Possession;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class PossessionCrud
 * @package App\DAL
 */
class PossessionCrud
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * PossessionCrud constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Possession $possession
     */
    public function createPossession(Possession $possession)
    {
        $this->entityManager->persist($possession);
        $this->entityManager->flush();
    }
}
