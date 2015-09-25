<?php

namespace Flo\Bundle\AscultaiciBackendBundle\Controller;

use Flo\Bundle\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Flo\Bundle\AscultaiciBundle\Entity\Playlist;
use Flo\Bundle\AscultaiciBackendBundle\Form\PlaylistType;

class PlaylistController extends Controller
{
    public function listAction()
    {
        $playlists = $this->get('flo_ascultaici.handler.playlist.read')->findByUser($this->getCurrentUser());
        return $this->render('FloAscultaiciBackendBundle:Playlist:list.html.twig', ['entities' => $playlists]);
    }

    public function createAction(Request $request)
    {
        $entity = new Playlist;
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('ascultaici_playlist_show', array('slug' => $entity->getSlug())));
        }

        return $this->render('FloAscultaiciBackendBundle:Playlist:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Playlist entity.
     *
     * @param Playlist $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Playlist $entity)
    {
        $form = $this->createForm(new PlaylistType(), $entity, array(
            'action' => $this->generateUrl('ascultaici_playlist_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Playlist entity.
     *
     */
    public function newAction()
    {
        $entity = new Playlist();
        $form   = $this->createCreateForm($entity);

        return $this->render('FloAscultaiciBackendBundle:Playlist:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Playlist.
     */
    public function showAction($slug)
    {
        $currentUser = $this->getCurrentUser();
        $playlist = $this->get('flo_ascultaici.handler.playlist.read')->findOneWithTracks($currentUser, $slug);

        if (!$playlist) {
            throw $this->createNotFoundException(sprintf('Unable to find playlist %d.', $slug));
        }

        $deleteForm = $this->createDeleteForm($playlist->getSlug());

        return $this->render('FloAscultaiciBackendBundle:Playlist:show.html.twig', [
            'playlist'      => $playlist,
            'delete_form' => $deleteForm->createView()
        ]);
    }

    /**
     * @param string $slug
     */
    public function editAction($slug)
    {
        $currentUser = $this->getCurrentUser();
        $entity = $this->get('flo_ascultaici.handler.playlist.read')->findOneWithTracks($currentUser, $slug);

        if (!$entity) {
            $message = sprintf('Cannot find playlist "%s"', $slug);
            throw $this->createNotFoundException($message);
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($entity->getSlug());

        return $this->render('FloAscultaiciBackendBundle:Playlist:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Playlist entity.
    *
    * @param Playlist $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Playlist $entity)
    {
        $form = $this->createForm(new PlaylistType(), $entity, array(
            'action' => $this->generateUrl('ascultaici_playlist_update', array('slug' => $entity->getSlug())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Playlist entity.
     */
    public function updateAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();

        $currentUser = $this->getCurrentUser();
        $entity = $this->get('flo_ascultaici.handler.playlist.read')->findOneWithTracks($currentUser, $slug);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Playlist entity.');
        }

        $deleteForm = $this->createDeleteForm($entity->getSlug());
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            return $this->redirect($this->generateUrl('ascultaici_playlist_edit', ['slug' => $entity->getSlug()]));
        }

        return $this->render('FloAscultaiciBackendBundle:Playlist:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Playlist entity.
     *
     * @param Request $request
     * @param $slug
     */
    public function deleteAction(Request $request, $slug)
    {
        $form = $this->createDeleteForm($slug);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $currentUser = $this->getCurrentUser();
            $playlist = $this->get('flo_ascultaici.handler.playlist.read')->findOneWithTracks($currentUser, $slug);

            if (!$playlist) {
                throw $this->createNotFoundException('Unable to find Playlist entity.');
            }

            $this->get('flo_ascultaici.handler.playlist.save')->delete($playlist);
        }

        return $this->redirect($this->generateUrl('ascultaici_playlist'));
    }

    /**
     * Creates a form to delete a Playlist entity by slug.
     *
     * @param string $slug The entity slug
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($slug)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ascultaici_playlist_delete', array('slug' => $slug)))
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
