<?php
/**
 * Created by IntelliJ IDEA.
 * User: RAGOSTINI
 * Date: 16/11/2018
 * Time: 16:06
 */

namespace App\DAL;

use App\Entity\Administrator;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Agent;
use Symfony\Component\HttpKernel\Tests\Controller;

class AdminCrud
{
    /*** @var EntityManagerInterface l'interface entity manager* nécessaire à la manipulation des opérations en base*/
    protected $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    public function GetInscriptionData($user)
    {
        $this->em->persist($user);
        $this->em->flush();
    }
}