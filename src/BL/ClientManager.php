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

/**
 * Class ClientManager
 * @package App\BL
 */
class ClientManager
{
    /*** @var EntityManagerInterface l'interface entity manager* nécessaire à la manipulation des opérations en base*/
    protected $em;

    /**
     * ClientManager constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param Possession $possession
     * @return array
     */
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

    /**
     * @return \App\Entity\Administrator[]|\App\Entity\Agency[]|\App\Entity\AgencyDirector[]|Client[]|object[]
     */
    public function GetListClient()
    {
        return $this->em->getRepository(Client::class)->findAll();
    }

    /**
     * @param $idUser
     * @return Client|object|null
     */
    public function getClientByUser($idUser){
        return $this->em->getRepository(Client::class)->findOneBy(array('user' => $idUser));
    }

    /**
     * @param $idClient
     * @return Client|object|null
     */
    public function GetClientById($idClient){
        return $this->em->getRepository(Client::class)->find($idClient);
    }

    /**
     * @param $idClient
     * @return mixed
     */
    public function GetClientAgencyById($idClient){
        return $this->em->getRepository(Client::class)->find($idClient)->getAgency();
    }

    /**
     * @param $idClient
     * @return mixed
     */
    public function GetClientAgentById($idClient){
        return $this->em->getRepository(Client::class)->find($idClient)->getAgent()->getUser();
    }

    /**
     * @param $idClient
     * @return User|null
     */
    public function GetClientUserById($idClient){
        return $this->em->getRepository(Client::class)->find($idClient)->getUser();
    }

    /**
     * @param Possession $possession
     * @param User $user
     */
    public function addToFavorites(Possession $possession, User $user){
        $favorite = new Favorite();
        $favorite->setClient($this->getClientByUser($user));
        $favorite->setPossession($possession);
        $this->em->persist($favorite);
        $this->em->flush();
    }

    /**
     * @param Possession $possession
     * @param User $user
     */
    public function removeFromFavorites(Possession $possession, User $user){
        $favorite = $this->em->getRepository(Favorite::class)->findOneBy(array('possession' => $possession, 'client' => $this->getClientByUser($user)));
        $this->em->remove($favorite);
        $this->em->flush();
    }
}
