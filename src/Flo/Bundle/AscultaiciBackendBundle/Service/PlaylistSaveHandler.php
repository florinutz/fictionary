<?php
namespace Flo\Bundle\AscultaiciBackendBundle\Service;

use Doctrine\ORM\EntityManager;
use Flo\Bundle\AscultaiciBundle\Entity\Playlist;
use Flo\Bundle\AscultaiciBundle\Repository\TrackRepository;
use Flo\Bundle\AscultaiciBundle\Repository\PlaylistRepository;
use Flo\Bundle\AscultaiciBundle\Service\AbstractSaveHandler;
use Flo\Bundle\AscultaiciBundle\Service\UrlFactory;
use Symfony\Component\Form\FormBuilder;

class PlaylistSaveHandler extends AbstractSaveHandler
{
    /**
     * @var PlaylistRepository
     */
    protected $playlistRepository;

    /**
     * @var TrackRepository
     */
    protected $trackRepository;

    /**
     * @param EntityManager $entityManager
     * @param PlaylistRepository $playlistRepository
     * @param TrackRepository $trackRepository
     */
    public function __construct(
        EntityManager $entityManager,
        PlaylistRepository $playlistRepository,
        TrackRepository $trackRepository
    ) {
        parent::__construct($entityManager);
        $this->playlistRepository = $playlistRepository;
        $this->trackRepository = $trackRepository;
    }

    /**
     * @param Playlist|int $playlist
     */
    public function delete($playlist)
    {
        if (is_numeric($playlist)) {
            $playlist = $this->getEntityManager()->getReference(Playlist::class, $playlist);
        }
        $this->trackRepository->deletePlaylistTracks($playlist);

        return $this->playlistRepository->delete($playlist);
    }

}
