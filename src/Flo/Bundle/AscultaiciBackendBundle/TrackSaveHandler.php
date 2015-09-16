<?php
namespace Flo\Bundle\AscultaiciBackendBundle;

use Flo\Bundle\AscultaiciBundle\Entity\Track;
use Flo\Bundle\AscultaiciBundle\Entity\Url\Url;
use Flo\Bundle\AscultaiciBundle\Repository\TrackRepository;
use Flo\Bundle\AscultaiciBundle\Entity\Playlist;
use Flo\Bundle\AscultaiciBundle\Repository\PlaylistRepository;
use Flo\Bundle\AscultaiciBundle\Repository\Url\UrlRepository;
use Symfony\Component\Form\FormBuilder;

class TrackSaveHandler
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
     * @param TrackRepository $trackRepository
     * @param PlaylistRepository $playlistRepository
     * @param UrlRepository $urlRepository
     */
    public function __construct(
        TrackRepository $trackRepository,
        PlaylistRepository $playlistRepository,
        UrlRepository $urlRepository
    ) {
        $this->trackRepository = $trackRepository;
        $this->playlistRepository = $playlistRepository;
        $this->urlRepository = $urlRepository;
    }

    /**
     * @param string|Url $url
     * @param int|Playlist $playlist
     * @param string $title
     * @param string $description
     * @param $start
     * @param $to
     */
    public function create($url, $playlist, $title = null, $description = null, $start = null, $to = null)
    {

    }

    /**
     * @param FormBuilder $form
     * @param Playlist $playlist
     */
    public function createFromForm($form, $playlist)
    {
        /** @var Track $track */
        $track = $form->getData();

        $url = $form->get('url')->getData();

        $url = $this->urlRepository->findOneOrCreate($url);
    }

}
