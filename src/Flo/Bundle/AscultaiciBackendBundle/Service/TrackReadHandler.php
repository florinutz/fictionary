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
     * @var UrlRepository
     */
    protected $urlRepository;

    /**
     * @param EntityManager $manager
     * @param TrackRepository $trackRepository
     * @param PlaylistRepository $playlistRepository
     * @param UrlRepository $urlRepository
     */
    public function __construct(
        EntityManager $manager,
        TrackRepository $trackRepository,
        PlaylistRepository $playlistRepository,
        UrlRepository $urlRepository
    ) {
        parent::__construct($manager);
        $this->trackRepository = $trackRepository;
        $this->playlistRepository = $playlistRepository;
        $this->urlRepository = $urlRepository;
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
