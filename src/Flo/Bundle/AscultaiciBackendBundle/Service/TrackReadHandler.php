<?php
namespace Flo\Bundle\AscultaiciBackendBundle\Service;

use Doctrine\ORM\EntityManager;
use Flo\Bundle\AscultaiciBundle\Entity\Track;
use Flo\Bundle\AscultaiciBundle\Entity\Url\Url;
use Flo\Bundle\AscultaiciBundle\Repository\TrackRepository;
use Flo\Bundle\AscultaiciBundle\Entity\Playlist;
use Flo\Bundle\AscultaiciBundle\Repository\PlaylistRepository;
use Flo\Bundle\AscultaiciBundle\Repository\Url\UrlRepository;
use Flo\Bundle\AscultaiciBundle\Service\AbstractReadHandler;

class TrackReadHandler extends AbstractReadHandler
{
    /**
     * @var TrackRepository
     */
    protected $trackRepository;

    /**
     * @var PlaylistRepository
     */
    protected $playlistRepository;

    /**
     * @param EntityManager $manager
     * @param TrackRepository $trackRepository
     * @param PlaylistRepository $playlistRepository
     */
    public function __construct(
        EntityManager $manager,
        TrackRepository $trackRepository,
        PlaylistRepository $playlistRepository
    ) {
        parent::__construct($manager);
        $this->trackRepository = $trackRepository;
        $this->playlistRepository = $playlistRepository;
    }

    /**
     * @param int|Url $url
     * @param int|Playlist $playlist
     *
     * @return Track|null
     */
    public function findOneByUrlAndPlaylist($url, $playlist)
    {
        return $this->trackRepository->findOneByUrlAndPlaylist($url, $playlist);
    }

}
