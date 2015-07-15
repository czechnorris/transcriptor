<?php
/**
 * This file is part of the transcriptor project.
 */

namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


/**
 * Class IndexController
 
 * @package AppBundle\Controller
 * @author  Petr Pokorný <petr@petrpokorny.cz>
 */
class IndexController extends Controller {

    /**
     * Index action
     *
     * @Route("/", name="index")
     * @Template(engine="php")
     *
     * @return Response
     */
    public function indexAction() {
    }

    /**
     * Rules action
     *
     * @Route("/rules", name="rules")
     * @Template(engine="php")
     *
     * @return Response
     */
    public function rulesAction() {
    }

    /**
     * Sign in action
     *
     * @Route("/signin", name="signin")
     *
     * @return Response
     */
    public function signInAction() {
        return new Response(json_encode($this->getUser()));
    }

}