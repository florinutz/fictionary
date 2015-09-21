<?php
namespace Flo\Bundle\AscultaiciBackendBundle\Service;

use Doctrine\ORM\EntityManager;
use Flo\Bundle\AscultaiciBundle\Entity\Track;
use Flo\Bundle\AscultaiciBundle\Entity\Url\Url;
use Flo\Bundle\AscultaiciBundle\Entity\Url\UrlYoutube;
use Flo\Bundle\AscultaiciBundle\Repository\TrackRepository;
use Flo\Bundle\AscultaiciBundle\Entity\Playlist;
use Flo\Bundle\AscultaiciBundle\Repository\PlaylistRepository;
use Flo\Bundle\AscultaiciBundle\Repository\Url\UrlMixcloudRepository;
use Flo\Bundle\AscultaiciBundle\Repository\Url\UrlRepository;
use Flo\Bundle\AscultaiciBundle\Repository\Url\UrlSoundcloudRepository;
use Flo\Bundle\AscultaiciBundle\Repository\Url\UrlYoutubeRepository;
use Flo\Bundle\AscultaiciBundle\Service\AbstractSaveHandler;
use Flo\Bundle\AscultaiciBundle\Service\UrlFactory;
use Symfony\Component\Form\FormBuilder;

class TrackSaveHandler extends AbstractSaveHandler
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
     * @var UrlFactory
     */
    protected $urlFactory;

    /**
     * @var UrlSaveHandler
     */
    private $urlSaveHandler;

    /**
     * @param EntityManager $entityManager
     * @param UrlFactory $urlFactory
     * @param UrlSaveHandler $urlSaveHandler
     * @param TrackRepository $trackRepository
     * @param PlaylistRepository $playlistRepository
     */
    public function __construct(
        EntityManager $entityManager,
        UrlFactory $urlFactory,
        UrlSaveHandler $urlSaveHandler,
        TrackRepository $trackRepository,
        PlaylistRepository $playlistRepository
    ) {
        parent::__construct($entityManager);
        $this->urlFactory = $urlFactory;
        $this->urlSaveHandler = $urlSaveHandler;
        $this->trackRepository = $trackRepository;
        $this->playlistRepository = $playlistRepository;
    }

    /**
     * @param Url $url
     * @param int|Playlist $playlist
     * @param string $title
     * @param string $description
     * @param $start
     * @param $stop
     *
     * @return Track
     */
    public function create(
        Url $url,
        Playlist $playlist,
        $title = null,
        $description = null,
        $start = null,
        $stop = null
    ) {
        $track = new Track;

        $track->setPlaylist($playlist);
        $track->setUrl($url);
        $track->setTitle($title);
        $track->setDescription($description);
        $track->setStart($start);
        $track->setStop($stop);

        $em = $this->getEntityManager();
        $em->persist($track);
        $em->flush($track);

        return $track;
    }

    /**
     * @param FormBuilder $form
     * @param Playlist $playlist
     *
     * @return Track
     */
    public function createFromForm($form, Playlist $playlist)
    {
        /** @var Track $track */
        $track = $form->getData();
        $urlString = $form->get('url')->getData();

        $url = $this->urlFactory->generate($urlString);
        $url = $this->urlSaveHandler->save($url);

        if (!$url) {
            throw new \InvalidArgumentException(sprintf('Invalid url "%s"', $urlString));
        }

        $track->setUrl($url);
        $track->setPlaylist($playlist);

        $em = $this->getEntityManager();
        $em->persist($track);
        $em->flush($track);

        return $track;
    }

}
