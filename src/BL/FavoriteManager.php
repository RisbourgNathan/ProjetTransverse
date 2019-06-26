<?php


namespace App\BL;


use App\Entity\Client;
use App\Entity\Favorite;
use App\Entity\Possession;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class FavoriteManager
 * @package App\BL
 */
class FavoriteManager
{
    /*** @var EntityManagerInterface l'interface entity manager* nécessaire à la manipulation des opérations en base*/
    protected $em;

    /**
     * FavoriteManager constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param Possession $possession
     * @param Client $client
     * @return Favorite|object|null
     */
    public function getFavorite(Possession $possession, Client $client)
    {
        if ($this->em->getRepository(Favorite::class)->findOneBy(array('possession' => $possession, 'client' => $client)) == null){
            return null;
        }
        else {
            return $this->em->getRepository(Favorite::class)->findOneBy(array('possession' => $possession, 'client' => $client));
        }
    }

    /**
     * @param Possession $possession
     * @param User $user
     */
    public function removeNotificationForUser(Possession $possession, User $user)
    {
        $clientManager = new ClientManager($this->em);

        $favorite = $this->getFavorite($possession, $clientManager->getClientByUser($user));

        if ($favorite != null)
        {
            $favorite->setHasNotification(false);
            $user->setNotifications($this->getNumberOfNotifications($user));

            $this->em->persist($favorite);
            $this->em->persist($user);
            $this->em->flush();
        }
        else {
            $user->setNotifications($this->getNumberOfNotifications($user));
            $this->em->persist($user);
        }
    }

    /**
     * @param User $user
     * @return int
     */
    public function getNumberOfNotifications(User $user) : int
    {
        $clientManager = new ClientManager($this->em);
        $client = $clientManager->getClientByUser($user);

        $allFavorites = $this->em->getRepository(Favorite::class)->findBy(array("client" => $client, "hasNotification" => true));

        return count($allFavorites);
    }
}
