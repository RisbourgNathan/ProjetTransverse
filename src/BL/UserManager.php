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

class UserManager
{

    private $clientManager;
    private $security;

    /*** @var EntityManagerInterface l'interface entity manager* nécessaire à la manipulation des opérations en base*/
    protected $em;
    public function __construct(EntityManagerInterface $em, Security $security)
    {
        $this->em = $em;
        $this->security = $security;
        $this->clientManager = new ClientManager($em);
    }

    public function GetClientIdbyUser(){
        $userClient = $this->em->getRepository(User::class)->find($this->security->getUser());
        $client = $this->em->getRepository(Client::class)->findOneBy(array('user' => $userClient->getId()));
        return $client;
    }

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

    public function increaseNotification(User $user)
    {
        $newNotifNumber = $user->getNotifications() + 1;
        $user->setNotifications($newNotifNumber);
//        $this->saveUser($user);
    }

    public function clearNotifications(User $user)
    {
        $user->setNotifications(0);
//        $this->saveUser($user);
    }

    public function saveUser($user)
    {
        $this->em->persist($user);
        $this->em->flush();
    }
}
