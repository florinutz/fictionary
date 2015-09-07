<?php

namespace Flo\Bundle\FictionaryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FrontController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FloFictionaryBundle:Fiction')->findAll();

        return $this->render('FloFictionaryBundle:Front:index.html.twig', [
            'entities' => $entities
        ]);
    }

    /**
     * Finds and displays a Fiction entity.
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FloFictionaryBundle:Fiction')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Fiction entity.');
        }

        return $this->render('FloFictionaryBundle:Front:show.html.twig', [
            'entity' => $entity
        ]);
    }

}
