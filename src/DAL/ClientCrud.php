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
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * ClientCrud constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param $agent
     */
    public function getInscriptionData($agent)
    {
        $this->entityManager->persist($agent);
        $this->entityManager->flush();
    }

    /**
     * @param Client $client
     * @param User $user
     */
    public function createClient(Client $client, User $user)
    {
        $client->setUser($user);
        $this->entityManager->persist($client);
        $this->entityManager->flush();
    }
}
