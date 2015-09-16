<?php

namespace Flo\Bundle\AscultaiciBackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FloAscultaiciBackendBundle:Default:index.html.twig');
    }
}
