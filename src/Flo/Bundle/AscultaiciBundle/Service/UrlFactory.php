<?php
namespace Flo\Bundle\AscultaiciBundle\Service;

use Flo\Bundle\AscultaiciBundle\Entity\Url\UrlMixcloud;
use Flo\Bundle\AscultaiciBundle\Entity\Url\UrlSoundcloud;
use Flo\Bundle\AscultaiciBundle\Entity\Url\UrlYoutube;
use Flo\Bundle\AscultaiciBundle\Repository\Url\UrlRepository;

class UrlFactory
{
    /**
     * @param string $url
     *
     * @return bool|UrlYoutube|UrlSoundcloud|UrlMixcloud
     */
    public static function generate($url)
    {
        $instance = false;

        if (UrlRepository::isYoutubeUrl($url)) {
            $instance = new UrlYoutube;
        }
        elseif (UrlRepository::isSoundcloudUrl($url)) {
            $instance = new UrlSoundcloud;
        }
        elseif (UrlRepository::isMixcloudUrl($url)) {
            $instance = new UrlMixcloud;
        }

        if ($instance) {
            $instance->setUrl($url);
        }

        return $instance;
    }
}
