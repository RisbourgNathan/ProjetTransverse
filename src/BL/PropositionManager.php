<?php
/**
 * Created by PhpStorm.
 * User: NathanR
 * Date: 5/22/2019
 * Time: 11:42 AM
 */

namespace App\BL;


use App\Entity\Client;
use App\Entity\Possession;
use App\Entity\Proposition;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class PropositionManager
 * @package App\BL
 */
class PropositionManager
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * PropositionManager constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Client $client
     * @return Proposition[]|object[]
     */
    public function getVisibleClientPropositions(Client $client)
    {
        return $this->entityManager->getRepository(Proposition::class)->findBy(array('client' => $client, 'shouldBeDisplayed' => true));
    }

    /**
     * @param Proposition $proposition
     */
    public function saveProposition(Proposition $proposition)
    {
        $this->entityManager->persist($proposition);
        $this->entityManager->flush();
    }

    /**
     * @param $id
     * @return Proposition|object|null
     */
    public function getPropositionById($id)
    {
       return $this->entityManager->getRepository(Proposition::class)->find($id);
    }

    /**
     * @param Possession $possession
     * @param User $user
     * @return bool
     */
    public function isPropositionAlreadyOngoing(Possession $possession, User $user) : bool
    {
        $clientManager = new ClientManager($this->entityManager);
        $propositions = $this->entityManager->getRepository(Proposition::class)->findBy(array("possession" => $possession, "client" => $clientManager->getClientByUser($user)));

        foreach ($propositions as $proposition)
        {
            if ($proposition->getState() == Proposition::$STATE_COUNTER_PROPOSITION || $proposition->getState() == Proposition::$STATE_PROPOSITION)
            {
                return true;
            }
        }

        return false;
    }
}
