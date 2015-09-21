<?php
namespace Flo\Bundle\AscultaiciBackendBundle\Service;

use Doctrine\ORM\EntityManager;
use Flo\Bundle\AscultaiciBundle\Entity\Url\Url;
use Flo\Bundle\AscultaiciBundle\Repository\Url\UrlMixcloudRepository;
use Flo\Bundle\AscultaiciBundle\Repository\Url\UrlRepository;
use Flo\Bundle\AscultaiciBundle\Repository\Url\UrlSoundcloudRepository;
use Flo\Bundle\AscultaiciBundle\Repository\Url\UrlYoutubeRepository;
use Flo\Bundle\AscultaiciBundle\Service\AbstractReadHandler;

class UrlSaveHandler extends AbstractReadHandler
{
    /**
     * @var UrlRepository
     */
    protected $urlRepository;

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
     * @param UrlRepository $urlRepository
     * @param UrlYoutubeRepository $urlYoutubeRepository
     * @param UrlSoundcloudRepository $urlSoundcloudRepository
     * @param UrlMixcloudRepository $urlMixcloudRepository
     */
    public function __construct(
        EntityManager $manager,
        UrlRepository $urlRepository,
        UrlYoutubeRepository $urlYoutubeRepository,
        UrlSoundcloudRepository $urlSoundcloudRepository,
        UrlMixcloudRepository $urlMixcloudRepository
    ) {
        parent::__construct($manager);
        $this->urlRepository = $urlRepository;
        $this->urlYoutubeRepository = $urlYoutubeRepository;
        $this->urlSoundcloudRepository = $urlSoundcloudRepository;
        $this->urlMixcloudRepository = $urlMixcloudRepository;
    }

    /**
     * @param string $urlString
     */
    public function create($urlString)
    {

    }

    /**
     * @param Url $url
     *
     * @return Url
     */
    public function save($url)
    {
    }
}
