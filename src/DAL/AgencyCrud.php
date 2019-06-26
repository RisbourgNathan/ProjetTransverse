<?php
/**
 * Created by IntelliJ IDEA.
 * User: RAGOSTINI
 * Date: 15/11/2018
 * Time: 15:26
 */

namespace App\DAL;
use App\Entity\Agent;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Agency;
use App\Entity\User;
use Symfony\Component\HttpKernel\Tests\Controller;
use App\Repository\AgencyRepository;

/**
 * Class AgencyCrud
 * @package App\DAL
 */
class AgencyCrud
{
    /*** @var EntityManagerInterface l'interface entity manager* nécessaire à la manipulation des opérations en base*/
    protected $em;

    /**
     * AgencyCrud constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param $agency
     */
    public function GetInscriptionData($agency)
    {
        $this->em->persist($agency);
        $this->em->flush();
    }

    /**
     * @param $idAgencyDirector
     * @return Agency|object|null
     */
    public function getAgencyById($idAgencyDirector)
    {
        $agency = $this->em->getRepository(Agency::class)->find($idAgencyDirector);
        return $agency;
    }

    /**
     * @param $idAgency
     */
    public function removeAgency($idAgency)
    {
        $agency = $this->em->getRepository(Agency::class)->find($idAgency);
        $agents = $this->em->getRepository(Agency::class)->find($idAgency)->getAgents();
        foreach ($agents as $agent){
            $user = $this->em->getRepository(Agent::class)->find($agent)->getUser();
            $this->em->remove($agent);
            $this->em->flush();
            $this->em->remove($user);
            $this->em->flush();
        }
        $this->em->remove($agency);
        $this->em->flush();
    }
}

