<?php
/**
 * Created by IntelliJ IDEA.
 * User: RAGOSTINI
 * Date: 15/11/2018
 * Time: 14:38
 */

namespace App\DAL;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Agent;
use Symfony\Component\HttpKernel\Tests\Controller;

class AgentCrud
{
    /*** @var EntityManagerInterface l'interface entity manager* nécessaire à la manipulation des opérations en base*/
    protected $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getInscriptionData($agent)
    {
        $this->em->persist($agent);
        $this->em->flush();
    }

    public function getListAgent(){
        return $this->em->getRepository(Agent::class)->findAll();

    }
    public function getListUserAgent(){
        $listAgent = $this->getListAgent();
        $listUserAgent = array();
        foreach ($listAgent as $agent)
        {
            array_push($listUserAgent,$agent->getUser());
        }
        return $listUserAgent;
    }
}