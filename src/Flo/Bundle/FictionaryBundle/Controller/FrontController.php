<?php

namespace Flo\Bundle\FictionaryBundle\Controller;

use Flo\Bundle\FictionaryBundle\Entity\Fiction;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FrontController extends Controller
{
    public function contactAction()
    {
        return $this->render('FloFictionaryBundle:Front:contact.html.twig');
    }

    public function homeAction()
    {
        return $this->render('FloFictionaryBundle:Front:home.html.twig');
    }

    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FloFictionaryBundle:Fiction')->findAll();

        return $this->render('FloFictionaryBundle:Front:list.html.twig', [
            'entities' => $entities
        ]);
    }

    public function showAction($slug)
    {
        /** @var Fiction $fiction */
        if (!$fiction = $this->get('flo_fictionary.reader.fiction')->findBySlug($slug)) {
            throw $this->createNotFoundException('No such fiction.');
        }

        return $this->render('FloFictionaryBundle:Front:show.html.twig', [
            'entity' => $fiction
        ]);
    }

    public function randomAction()
    {
        $entity = $this->get('flo_fictionary.reader.fiction')->getRandom();

        return $this->render('FloFictionaryBundle:Front:show.html.twig', [
            'entity' => $entity
        ]);
    }

}
