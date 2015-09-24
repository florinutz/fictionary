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
     * @var UrlSaveHandler
     */
    private $urlSaveHandler;

    /**
     * @param EntityManager $entityManager
     * @param UrlSaveHandler $urlSaveHandler
     * @param PlaylistRepository $playlistRepository
     */
    public function __construct(
        EntityManager $entityManager,
        UrlSaveHandler $urlSaveHandler,
        PlaylistRepository $playlistRepository
    ) {
        parent::__construct($entityManager);
        $this->urlSaveHandler = $urlSaveHandler;
        $this->playlistRepository = $playlistRepository;
    }

    /**
     * @param Playlist|int $playlist
     */
    public function delete($playlist)
    {
        if (is_numeric($playlist)) {
            $playlist = $this->getEntityManager()->getReference(Playlist::class, $playlist);
        }
        return $this->playlistRepository->delete($playlist);
    }

}
