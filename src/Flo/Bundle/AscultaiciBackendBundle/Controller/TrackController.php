<?php

namespace Flo\Bundle\AscultaiciBackendBundle\Controller;

use Flo\Bundle\AscultaiciBundle\Entity\Playlist;
use Flo\Bundle\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Flo\Bundle\AscultaiciBundle\Entity\Track;
use Flo\Bundle\AscultaiciBackendBundle\Form\TrackType;

class TrackController extends Controller
{
    /**
     * Lists all Track entities.
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FloAscultaiciBundle:Track')->findAll();

        return $this->render('FloAscultaiciBackendBundle:Track:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Track entity.
     * @param Request $request
     * @param Playlist $playlist
     */
    public function createAction(Request $request, Playlist $playlist)
    {
        $entity = new Track();
        $form = $this->createCreateForm($entity, $playlist);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $trackSaveHandler = $this->get('flo_ascultaici.handler.track.save');
            $trackSaveHandler->createFromForm($form, $playlist);
            $em = $this->getDoctrine()->getManager();
            $entity->setPlaylist($playlist);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('ascultaici_track_show', array('id' => $entity->getId())));
        }

        return $this->render('FloAscultaiciBackendBundle:Track:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * @param Track $entity The entity
     * @param Playlist $playlist
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Track $entity, Playlist $playlist)
    {
        $form = $this->createForm(new TrackType(), $entity, array(
            'action' => $this->generateUrl('ascultaici_track_create', [
                'playlistSlug' => $playlist->getId()
            ]),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Track entity.
     *
     * @param string $playlistSlug
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction($playlistSlug)
    {
        $entity = new Track();
        $currentUser = $this->getCurrentUser();
        $playlist = $this->get('flo_ascultaici.handler.playlist.read')->findOneWithTracks($currentUser, $playlistSlug);
        $form   = $this->createCreateForm($entity, $playlist);

        return $this->render('FloAscultaiciBackendBundle:Track:new.html.twig', array(
            'entity' => $entity,
            'playlist' => $playlist,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Track entity.
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FloAscultaiciBundle:Track')->findWithUrlAndTags($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Track entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('FloAscultaiciBackendBundle:Track:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Track entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FloAscultaiciBundle:Track')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Track entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('FloAscultaiciBackendBundle:Track:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Track entity.
    *
    * @param Track $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Track $entity)
    {
        $form = $this->createForm(new TrackType(), $entity, array(
            'action' => $this->generateUrl('ascultaici_track_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Track entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FloAscultaiciBundle:Track')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Track entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('ascultaici_track_edit', array('id' => $id)));
        }

        return $this->render('FloAscultaiciBackendBundle:Track:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Track entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FloAscultaiciBundle:Track')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Track entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('ascultaici_track'));
    }

    /**
     * Creates a form to delete a Track entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ascultaici_track_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    /**
     * @return User
     */
    protected function getCurrentUser()
    {
        return $this->get('security.token_storage')->getToken()->getUser();
    }
}
