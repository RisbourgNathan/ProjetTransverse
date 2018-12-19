<?php
/**
 * Created by IntelliJ IDEA.
 * User: RAGOSTINI
 * Date: 17/12/2018
 * Time: 17:20
 */

namespace App\BL;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\AgencyDirector;
use Symfony\Component\HttpKernel\Tests\Controller;

class AgencyDirectorManager
{
    /*** @var EntityManagerInterface l'interface entity manager* nécessaire à la manipulation des opérations en base*/
    protected $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getListAgencyDirector(){
        return $this->em->getRepository(AgencyDirector::class)->findAll();
    }
}