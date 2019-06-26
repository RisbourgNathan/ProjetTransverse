<?php
/**
 * Created by IntelliJ IDEA.
 * User: RAGOSTINI
 * Date: 17/12/2018
 * Time: 17:19
 */

namespace App\BL;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Administrator;
use Symfony\Component\HttpKernel\Tests\Controller;

/**
 * Class AdminManager
 * @package App\BL
 */
class AdminManager
{
    /*** @var EntityManagerInterface l'interface entity manager* nécessaire à la manipulation des opérations en base*/
    protected $em;

    /**
     * AdminManager constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @return Administrator[]|\App\Entity\Agency[]|\App\Entity\AgencyDirector[]|\App\Entity\Client[]|object[]
     */
    public function getListAdmin(){
        return $this->em->getRepository(Administrator::class)->findAll();

    }
}
