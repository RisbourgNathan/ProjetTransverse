<?php
/**
 * Created by IntelliJ IDEA.
 * User: RAGOSTINI
 * Date: 07/11/2018
 * Time: 13:57
 */

namespace App\Controller;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function getIndex() {
        return $this->render('index/index.html.twig');
    }
}