<?php
/**
 * Created by IntelliJ IDEA.
 * User: RAGOSTINI
 * Date: 17/12/2018
 * Time: 16:57
 */

namespace App\DAL;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\AgencyDirector;
use Symfony\Component\HttpKernel\Tests\Controller;

class AgencyDirectorCrud
{
    /*** @var EntityManagerInterface l'interface entity manager* nécessaire à la manipulation des opérations en base*/
    protected $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getInscriptionData($agencyDirector)
    {
        $this->em->persist($agencyDirector);
        $this->em->flush();
    }

    public function getUserAgencyDirectorById($idAgencyDirector)
    {
        $user = $this->em->getRepository(AgencyDirector::class)->find($idAgencyDirector)->getUser();
        return $user;
    }

    public function removeAgencyDirector($idAgencyDirector)
    {
        $iduser = $this->em->getRepository(AgencyDirector::class)->find($idAgencyDirector)->getUser()->getId();
        $agent = $this->em->getRepository(AgencyDirector::class)->find($idAgencyDirector);
        $this->em->remove($agent);
        $this->em->flush();
        $user = $this->em->getRepository(User::class)->find($iduser);
        $this->em->remove($user);
        $this->em->flush();
    }
}