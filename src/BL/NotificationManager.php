<?php
/**
 * Created by PhpStorm.
 * User: NathanR
 * Date: 6/21/2019
 * Time: 1:57 PM
 */

namespace App\BL;


use Doctrine\ORM\EntityManagerInterface;

/**
 * Class NotificationManager
 * @package App\BL
 */
class NotificationManager
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * NotificationManager constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


}
