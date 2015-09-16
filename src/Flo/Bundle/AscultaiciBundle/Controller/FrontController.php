<?php
namespace Flo\Bundle\AscultaiciBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FrontController extends Controller
{
    public function indexAction(Request $request)
    {
        return $this->render('FloAscultaiciBundle:Front:index.html.twig');
    }
}
