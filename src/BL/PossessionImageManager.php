<?php
/**
 * Created by PhpStorm.
 * User: NathanR
 * Date: 3/27/2019
 * Time: 5:37 PM
 */

namespace App\BL;


use App\Entity\Possession;
use App\Entity\PossessionImage;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class PossessionImageManager
 * @package App\BL
 */
class PossessionImageManager
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * PossessionImageManager constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param $id
     * @return PossessionImage
     */
    public function getById($id): PossessionImage
    {
        return $this->entityManager->getRepository(PossessionImage::class)->find($id);
    }
}
