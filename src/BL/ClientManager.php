<?php
/**
 * Created by IntelliJ IDEA.
 * User: RAGOSTINI
 * Date: 21/12/2018
 * Time: 14:50
 */

namespace App\BL;
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


    public function GetListClient()
    {
        return $this->em->getRepository(Client::class)->findAll();
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
}