<?php
/**
 * Created by IntelliJ IDEA.
 * User: RAGOSTINI
 * Date: 21/12/2018
 * Time: 14:50
 */

namespace App\BL;
use App\Entity\Favorite;
use App\Entity\Possession;
use App\Entity\User;
use App\Entity\Client;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Tests\Controller;

class ClientManager
{
    /*** @var EntityManagerInterface l'interface entity manager* nécessaire à la manipulation des opérations en base*/
    protected $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getClientsWithPossessionAsFavorite(Possession $possession)
    {
        $clients = array();

        $favorites = $this->em->getRepository(Favorite::class)->findBy(array('possession' => $possession->getId()));

        foreach ($favorites as $favorite)
        {
            array_push($clients, ($favorite->getClient()));
        }

        return $clients;
    }

    public function GetListClient()
    {
        return $this->em->getRepository(Client::class)->findAll();
    }

    public function getClientByUser($idUser){
        return $this->em->getRepository(Client::class)->findOneBy(array('user' => $idUser));
    }

    public function GetClientById($idClient){
        return $this->em->getRepository(Client::class)->find($idClient);
    }

    public function GetClientAgencyById($idClient){
        return $this->em->getRepository(Client::class)->find($idClient)->getAgency();
    }
    public function GetClientAgentById($idClient){
        return $this->em->getRepository(Client::class)->find($idClient)->getAgent()->getUser();
    }

    public function GetClientUserById($idClient){
        return $this->em->getRepository(Client::class)->find($idClient)->getUser();
    }

    public function addToFavorites(Possession $possession, User $user){
        $favorite = new Favorite();
        $favorite->setClient($this->getClientByUser($user));
        $favorite->setPossession($possession);
        $this->em->persist($favorite);
        $this->em->flush();
    }
    public function removeFromFavorites(Possession $possession, User $user){
        $favorite = $this->em->getRepository(Favorite::class)->findOneBy(array('possession' => $possession, 'client' => $this->getClientByUser($user)));
        $this->em->remove($favorite);
        $this->em->flush();
    }
}
