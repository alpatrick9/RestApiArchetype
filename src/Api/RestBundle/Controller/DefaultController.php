<?php

namespace Api\RestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ApiRestBundle:Default:index.html.twig');
    }
}
