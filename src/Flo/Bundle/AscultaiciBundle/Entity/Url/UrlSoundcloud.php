<?php

namespace Flo\Bundle\AscultaiciBundle\Entity\Url;

use Doctrine\ORM\Mapping as ORM;
use Flo\Bundle\AscultaiciBundle\Service\ApiCrawler;
use Symfony\Component\Validator\Constraints as Assert;
use Flo\Bundle\AscultaiciBundle\Validator\Constraint as AscultAssert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="Flo\Bundle\AscultaiciBundle\Repository\Url\UrlSoundcloudRepository")
 * @UniqueEntity({"soundcloud_user", "soundcloud_track"})
 */
class UrlSoundcloud extends Url
{
    const REGEX = '/soundcloud.com\/(?P<user>[^\/\?#]+)\/(?P<track>[^\/\?#]+).*/';
    /**
     * @var string
     *
     * @ORM\Column(name="soundcloud_user", type="string", length=255, nullable=false)
     */
    protected $user;

    /**
     * @var string
     *
     * @ORM\Column(name="soundcloud_track", type="string", length=255, nullable=false)
     */
    protected $track;

    /**
     * Assembles the url back from components
     *
     * @return string
     */
    public function getUrl()
    {
        return sprintf('https://soundcloud.com/%s/%s', $this->getUser(), $this->getTrack());
    }

    /**
     * Splits the url into components
     *
     * @param string $url
     */
    public function setUrl($url)
    {
        if (!preg_match(static::REGEX, $url, $matches)) {
            throw new \InvalidArgumentException("Invalid soundcloud url '$url'");
        }

        $this->setUser($matches['user']);
        $this->setTrack($matches['track']);
    }

    /**
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param string $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getTrack()
    {
        return $this->track;
    }

    /**
     * @param string $track
     */
    public function setTrack($track)
    {
        $this->track = $track;
    }

    /**
     * @return string
     */
    public function getOembedUrl()
    {
        return sprintf(ApiCrawler::OEMBED_SOUNDCLOUD, $this->getUrl());
    }
}
