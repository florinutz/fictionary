<?php
namespace Flo\Bundle\AscultaiciBackendBundle\Service;

use Doctrine\ORM\EntityManager;
use Flo\Bundle\AscultaiciBundle\Entity\Url\Url;
use Flo\Bundle\AscultaiciBundle\Repository\Url\UrlMixcloudRepository;
use Flo\Bundle\AscultaiciBundle\Repository\Url\UrlRepository;
use Flo\Bundle\AscultaiciBundle\Repository\Url\UrlSoundcloudRepository;
use Flo\Bundle\AscultaiciBundle\Repository\Url\UrlYoutubeRepository;
use Flo\Bundle\AscultaiciBundle\Service\AbstractReadHandler;

class UrlReadHandler extends AbstractReadHandler
{
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
     * @param UrlYoutubeRepository $urlYoutubeRepository
     * @param UrlSoundcloudRepository $urlSoundcloudRepository
     * @param UrlMixcloudRepository $urlMixcloudRepository
     */
    public function __construct(
        EntityManager $manager,
        UrlYoutubeRepository $urlYoutubeRepository,
        UrlSoundcloudRepository $urlSoundcloudRepository,
        UrlMixcloudRepository $urlMixcloudRepository
    ) {
        parent::__construct($manager);
        $this->urlYoutubeRepository = $urlYoutubeRepository;
        $this->urlSoundcloudRepository = $urlSoundcloudRepository;
        $this->urlMixcloudRepository = $urlMixcloudRepository;
    }
}
