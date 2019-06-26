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
use App\Entity\Agency;
use Symfony\Component\HttpKernel\Tests\Controller;

/**
 * Class AgencyManager
 * @package App\BL
 */
class AgencyManager
{
    /*** @var EntityManagerInterface l'interface entity manager* nécessaire à la manipulation des opérations en base*/
    protected $em;

    /**
     * AgencyManager constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @return \App\Entity\Administrator[]|Agency[]|\App\Entity\AgencyDirector[]|\App\Entity\Client[]|object[]
     */
    public function getListAgency(){
        return $this->em->getRepository(Agency::class)->findAll();

    }
}
