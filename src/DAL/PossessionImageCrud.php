<?php
/**
 * Created by PhpStorm.
 * User: NathanR
 * Date: 3/27/2019
 * Time: 5:27 PM
 */

namespace App\DAL;


use App\Entity\PossessionImage;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class PossessionImageCrud
 * @package App\DAL
 */
class PossessionImageCrud
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * PossessionImageCrud constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param PossessionImage $possessionImage
     */
    public function remove(PossessionImage $possessionImage)
    {
        $possessionImage->setPossession(null);
        $this->entityManager->remove($possessionImage);
        $this->entityManager->flush();
    }
}
