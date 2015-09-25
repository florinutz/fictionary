<?php
namespace Flo\Bundle\AscultaiciBackendBundle\Service;

use Doctrine\ORM\EntityManager;
use Flo\Bundle\AscultaiciBundle\Entity\Url\Url;
use Flo\Bundle\AscultaiciBundle\Repository\Url\UrlMixcloudRepository;
use Flo\Bundle\AscultaiciBundle\Repository\Url\UrlRepository;
use Flo\Bundle\AscultaiciBundle\Repository\Url\UrlSoundcloudRepository;
use Flo\Bundle\AscultaiciBundle\Repository\Url\UrlYoutubeRepository;
use Flo\Bundle\AscultaiciBundle\Service\AbstractReadHandler;
use Flo\Bundle\AscultaiciBundle\Service\UrlFactory;

class UrlSaveHandler extends AbstractReadHandler
{
    /**
     * @var UrlFactory
     */
    protected $urlFactory;

    /**
     * @var UrlYoutubeRepository
     */
    protected $urlYoutubeRepository;

    /**
     * @var UrlSoundcloudRepository
     */
    protected $urlSoundcloudRepository;

    /**
     * @var UrlMixcloudRepository
     */
    protected $urlMixcloudRepository;

    /**
     * @param EntityManager $manager
     * @param UrlFactory $urlFactory
     * @param UrlYoutubeRepository $urlYoutubeRepository
     * @param UrlSoundcloudRepository $urlSoundcloudRepository
     * @param UrlMixcloudRepository $urlMixcloudRepository
     */
    public function __construct(
        EntityManager $manager,
        UrlFactory $urlFactory,
        UrlYoutubeRepository $urlYoutubeRepository,
        UrlSoundcloudRepository $urlSoundcloudRepository,
        UrlMixcloudRepository $urlMixcloudRepository
    ) {
        parent::__construct($manager);
        $this->urlFactory = $urlFactory;
        $this->urlYoutubeRepository = $urlYoutubeRepository;
        $this->urlSoundcloudRepository = $urlSoundcloudRepository;
        $this->urlMixcloudRepository = $urlMixcloudRepository;
    }

    /**
     * This method receives an url string and saves it if not already saved.
     *
     * @param string $urlString
     *
     * @return Url the persisted object
     */
    public function save($urlString)
    {
        if (!$instance = $this->urlFactory->generate($urlString)) {
            throw new \InvalidArgumentException(sprintf('Url "%s" is not supported', $urlString));
        }
        $persistedInstance = $this->getRepo($instance)->createOrRetrieve($instance);
        return $persistedInstance;
    }

    /**
     * @param Url $url
     * @return UrlRepository
     * @throws \Exception
     */
    protected function getRepo(Url $url)
    {
        if ($url->getType() == UrlRepository::TYPE_YOUTUBE) {
            return $this->urlYoutubeRepository;
        }
        if ($url->getType() == UrlRepository::TYPE_SOUNDCLOUD) {
            return $this->urlSoundcloudRepository;
        }
        if ($url->getType() == UrlRepository::TYPE_MIXCLOUD) {
            return $this->urlMixcloudRepository;
        }
        throw new \Exception('Unknown url type');
    }
}
