<?php
/**
 * Created by IntelliJ IDEA.
 * User: RAGOSTINI
 * Date: 17/12/2018
 * Time: 17:16
 */

namespace App\BL;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Agent;
use Symfony\Component\HttpKernel\Tests\Controller;

/**
 * Class AgentManager
 * @package App\BL
 */
class AgentManager
{
    /*** @var EntityManagerInterface l'interface entity manager* nécessaire à la manipulation des opérations en base*/
    protected $em;

    /**
     * AgentManager constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @return \App\Entity\Administrator[]|\App\Entity\Agency[]|\App\Entity\AgencyDirector[]|Agent[]|\App\Entity\Client[]|object[]
     */
    public function getListAgent(){
        return $this->em->getRepository(Agent::class)->findAll();
    }

    /**
     * @param User $user
     * @return Agent|object|null
     */
    public function getAgentByUser(User $user){
        return $this->em->getRepository(Agent::class)->findOneBy(array('user' => $user));
    }

    /**
     * @param $agentId
     * @return Agent|object|null
     */
    public function getAgentById($agentId){
        return $this->em->getRepository(Agent::class)->find($agentId);
    }
}
