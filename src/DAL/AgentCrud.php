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

/**
 * Class AgentCrud
 * @package App\DAL
 */
class AgentCrud
{
    /*** @var EntityManagerInterface l'interface entity manager* nécessaire à la manipulation des opérations en base*/
    protected $em;

    /**
     * AgentCrud constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param $agent
     */
    public function getInscriptionData($agent)
    {
        $this->em->persist($agent);
        $this->em->flush();
    }

    /**
     * @param $idAgent
     * @return User|null
     */
    public function getUserAgentById($idAgent)
    {
        $user = $this->em->getRepository(Agent::class)->find($idAgent)->getUser();
        return $user;
    }

    /**
     * @param $idAgent
     */
    public function removeAgent($idAgent)
    {
        $iduser = $this->em->getRepository(Agent::class)->find($idAgent)->getUser()->getId();
        $agent = $this->em->getRepository(Agent::class)->find($idAgent);
        $this->em->remove($agent);
        $this->em->flush();
        $user = $this->em->getRepository(User::class)->find($iduser);
        $this->em->remove($user);
        $this->em->flush();
    }
}
