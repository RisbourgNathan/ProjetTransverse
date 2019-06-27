<?php
/**
 * Created by PhpStorm.
 * User: NathanR
 * Date: 12/19/2018
 * Time: 11:30 PM
 */

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AgentController
 * @package App\Controller
 * @Route("/agent", name="agent_")
 */
class AgentController extends AbstractController
{

    /**
     * AgentController constructor.
     */
    public function __construct()
    {

    }

    /**
     * @Route("/noClientError", name="hasNoClientError")
     * @IsGranted("ROLE_AGENT")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function agentHasNoClientError()
    {
        return $this->render('errors/agent/agentHasNoClientErrorPage.html.twig');
    }
}