<?php
/**
 * Created by IntelliJ IDEA.
 * User: RAGOSTINI
 * Date: 15/11/2018
 * Time: 15:26
 */

namespace App\DAL;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Agency;
use Symfony\Component\HttpKernel\Tests\Controller;

class AgencyCrud
{
    /*** @var EntityManagerInterface l'interface entity manager* nécessaire à la manipulation des opérations en base*/
    protected $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    public function GetInscriptionData($agency)
    {
        $this->em->persist($agency);
        $this->em->flush();
    }
}