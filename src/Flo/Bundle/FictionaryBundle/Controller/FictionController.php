<?php

namespace Flo\Bundle\FictionaryBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Flo\Bundle\FictionaryBundle\Entity\Fiction;
use Flo\Bundle\FictionaryBundle\Form\FictionType;

/**
 * Fiction controller.
 *
 */
class FictionController extends Controller
{

    /**
     * Lists all Fiction entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FloFictionaryBundle:Fiction')->findAll();

        return $this->render('FloFictionaryBundle:Fiction:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Fiction entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Fiction();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('back_show', array('id' => $entity->getId())));
        }

        return $this->render('FloFictionaryBundle:Fiction:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Fiction entity.
     *
     * @param Fiction $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Fiction $entity)
    {
        $form = $this->createForm(new FictionType(), $entity, array(
            'action' => $this->generateUrl('back_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Fiction entity.
     *
     */
    public function newAction()
    {
        $entity = new Fiction();
        $form   = $this->createCreateForm($entity);

        return $this->render('FloFictionaryBundle:Fiction:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Fiction entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FloFictionaryBundle:Fiction')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Fiction entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('FloFictionaryBundle:Fiction:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Fiction entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FloFictionaryBundle:Fiction')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Fiction entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('FloFictionaryBundle:Fiction:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Fiction entity.
    *
    * @param Fiction $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Fiction $entity)
    {
        $form = $this->createForm(new FictionType(), $entity, array(
            'action' => $this->generateUrl('back_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Fiction entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FloFictionaryBundle:Fiction')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Fiction entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('back_edit', array('id' => $id)));
        }

        return $this->render('FloFictionaryBundle:Fiction:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Fiction entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FloFictionaryBundle:Fiction')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Fiction entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('back'));
    }

    /**
     * Creates a form to delete a Fiction entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('back_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
