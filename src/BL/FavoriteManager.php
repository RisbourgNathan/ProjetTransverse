<?php


namespace App\BL;


use App\Entity\Client;
use App\Entity\Favorite;
use App\Entity\Possession;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class FavoriteManager
{
    /*** @var EntityManagerInterface l'interface entity manager* nécessaire à la manipulation des opérations en base*/
    protected $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getFavorite(Possession $possession, Client $client){
        if ($this->em->getRepository(Favorite::class)->findOneBy(array('possession' => $possession, 'client' => $client)) == null){
            return null;
        }
        else {
            return $this->em->getRepository(Favorite::class)->findOneBy(array('possession' => $possession, 'client' => $client));
            }
    }


}
