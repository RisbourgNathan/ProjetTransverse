<?php
/**
 * Created by IntelliJ IDEA.
 * User: RAGOSTINI
 * Date: 17/12/2018
 * Time: 17:20
 */

namespace App\BL;
use App\Entity\Client;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

/**
 * Class UserManager
 * @package App\BL
 */
class UserManager
{
    /**
     * @var ClientManager
     */
    private $clientManager;
    /**
     * @var Security
     */
    private $security;

    /*** @var EntityManagerInterface l'interface entity manager* nécessaire à la manipulation des opérations en base*/
    protected $em;

    /**
     * UserManager constructor.
     * @param EntityManagerInterface $em
     * @param Security $security
     */
    public function __construct(EntityManagerInterface $em, Security $security)
    {
        $this->em = $em;
        $this->security = $security;
        $this->clientManager = new ClientManager($em);
    }

    /**
     * @return Client|object|null
     */
    public function GetClientIdbyUser(){
        $userClient = $this->em->getRepository(User::class)->find($this->security->getUser());
        $client = $this->em->getRepository(Client::class)->findOneBy(array('user' => $userClient->getId()));
        return $client;
    }

    /**
     * @return array
     */
    public function getUsersOfClients(): array
    {
        $clients = $this->clientManager->GetListClient();
        $usersArray = array();
        foreach ($clients as $client)
        {
            array_push($usersArray, $client->getUser());
        }

        return $usersArray;
    }

    /**
     * @param User $user
     */
    public function increaseNotification(User $user)
    {
        $newNotifNumber = $user->getNotifications() + 1;
        $user->setNotifications($newNotifNumber);
//        $this->saveUser($user);
    }

    /**
     * @param User $user
     */
    public function clearNotifications(User $user)
    {
        $user->setNotifications(0);
//        $this->saveUser($user);
    }

    /**
     * @param $user
     */
    public function saveUser($user)
    {
        $this->em->persist($user);
        $this->em->flush();
    }
}
