<?php
/**
 * Created by IntelliJ IDEA.
 * User: RAGOSTINI
 * Date: 16/11/2018
 * Time: 16:06
 */

namespace App\DAL;

use App\Entity\Administrator;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Agent;
use Symfony\Component\HttpKernel\Tests\Controller;

/**
 * Class AdminCrud
 * @package App\DAL
 */
class AdminCrud
{
    /*** @var EntityManagerInterface l'interface entity manager* nécessaire à la manipulation des opérations en base*/
    protected $em;

    /**
     * AdminCrud constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param $user
     */
    public function GetInscriptionData($user)
    {
        $this->em->persist($user);
        $this->em->flush();
    }

    /**
     * @param $idAdmin
     * @return User|null
     */
    public function getUserAdminById($idAdmin)
    {
        $user = $this->em->getRepository(Administrator::class)->find($idAdmin)->getUser();
        return $user;
    }

    /**
     * @param $idAdmin
     */
    public function removeAdmin($idAdmin)
    {
        $iduser = $this->em->getRepository(Agent::class)->find($idAdmin)->getUser()->getId();
        $admin = $this->em->getRepository(Administrator::class)->find($idAdmin);
        $this->em->remove($admin);
        $this->em->flush();
        $user = $this->em->getRepository(User::class)->find($iduser);
        $this->em->remove($user);
        $this->em->flush();
    }
}
