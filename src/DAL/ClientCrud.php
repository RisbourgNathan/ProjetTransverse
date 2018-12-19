<?php
/**
 * Created by PhpStorm.
 * User: NathanR
 * Date: 12/19/2018
 * Time: 12:26 PM
 */

namespace App\DAL;


use App\Entity\Client;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ClientCrud
 * @package App\DAL
 * @Route("/client", name="client_")
 */
class ClientCrud
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createClient(Client $client, User $user)
    {
        $client->setUser($user);
        $client->setSponsor(null);
        $this->entityManager->persist($client);
        $this->entityManager->flush();
    }
}