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
    public function generate($url)
    {
        $instance = false;

        if ($this->isYoutube($url)) {
            $instance = new UrlYoutube;
        }
        elseif ($this->isSoundcloud($url)) {
            $instance = new UrlSoundcloud;
        }
        elseif ($this->isMixcloud($url)) {
            $instance = new UrlMixcloud;
        }

        if ($instance) {
            $instance->setUrl($url);
        }

        return $instance;
    }

    /**
     * @param string $url
     *
     * @return bool|string type (string, constant on the url repo) or false
     */
    public function getType($url)
    {
        if (preg_match(UrlYoutube::REGEX, $url)) {
            return UrlRepository::TYPE_YOUTUBE;
        }
        if (preg_match(UrlSoundcloud::REGEX, $url)) {
            return UrlRepository::TYPE_SOUNDCLOUD;
        }
        if (preg_match(UrlMixcloud::REGEX, $url)) {
            return UrlRepository::TYPE_MIXCLOUD;
        }

        return false;
    }

    /**
     * @param string $url
     *
     * @return bool
     */
    public function isYoutube($url)
    {
        return $this->getType($url) === UrlRepository::TYPE_YOUTUBE;
    }

    /**
     * @param string $url
     *
     * @return bool
     */
    public function isSoundcloud($url)
    {
        return $this->getType($url) === UrlRepository::TYPE_SOUNDCLOUD;
    }

    /**
     * @param string $url
     *
     * @return bool
     */
    public function isMixcloud($url)
    {
        return $this->getType($url) === UrlRepository::TYPE_MIXCLOUD;
    }
}
