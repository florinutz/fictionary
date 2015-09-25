<?php
namespace Flo\Bundle\AscultaiciBundle\Repository\Url;

use Doctrine\ORM\EntityRepository;
use Flo\Bundle\AscultaiciBundle\Entity\Url\Url;
use Flo\Bundle\AscultaiciBundle\Entity\Url\UrlMixcloud;
use Flo\Bundle\AscultaiciBundle\Entity\Url\UrlSoundcloud;
use Flo\Bundle\AscultaiciBundle\Entity\Url\UrlYoutube;

abstract class UrlRepository extends EntityRepository
{
    const TYPE_YOUTUBE = 'youtube';
    const TYPE_SOUNDCLOUD = 'soundcloud';
    const TYPE_MIXCLOUD = 'mixcloud';

    /**
     * @param Url $url
     *
     * @return array
     */
    abstract public function getIdentifyingArray(Url $url);

    public function save(Url $url)
    {
        $this->getEntityManager()->persist($url);
        $this->getEntityManager()->flush($url);
        return $url;
    }

    /**
     * @param Url $url
     *
     * @return Url
     */
    public function createOrRetrieve(Url $url)
    {
        if (!is_a($url, $this->getClassName())) {
            $message = sprintf('Invalid url instance: received "%s", expected "%s".', get_class($url), $this->getClassName());
            throw new \InvalidArgumentException($message);
        }
        if ($url->getId()) {
            return $url;
        }
        /** @var UrlYoutube $dbUrl */
        $identifyingArray = $this->getIdentifyingArray($url);
        if (!is_array($identifyingArray)) {
            throw new \LogicException('This identifying array is supposed to be an actual array.');
        }

        if ($dbUrl = $this->findOneBy($identifyingArray)) {
            return $dbUrl;
        } else {
            return $this->save($url);
        }
    }

    /**
     * @param string $url
     *
     * @return bool|string type (string, constant on the url repo) or false
     */
    public static function getType($url)
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
    public static function isYoutubeUrl($url)
    {
        return UrlRepository::getType($url) === UrlRepository::TYPE_YOUTUBE;
    }

    /**
     * @param string $url
     *
     * @return bool
     */
    public static function isSoundcloudUrl($url)
    {
        return UrlRepository::getType($url) === UrlRepository::TYPE_SOUNDCLOUD;
    }

    /**
     * @param string $url
     *
     * @return bool
     */
    public static function isMixcloudUrl($url)
    {
        return UrlRepository::getType($url) === UrlRepository::TYPE_MIXCLOUD;
    }

}
