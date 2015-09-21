<?php

namespace Flo\Bundle\AscultaiciBundle\Entity\Url;

use Doctrine\ORM\Mapping as ORM;
use Flo\Bundle\AscultaiciBundle\Service\Url\UrlDataMixcloud;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Flo\Bundle\AscultaiciBundle\Validator\Constraint as AscultAssert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Entity(repositoryClass="Flo\Bundle\AscultaiciBundle\Repository\Url\UrlMixcloudRepository")
 * @UniqueEntity({"mixcloud_user", "mixcloud_mix"})
 */
class UrlMixcloud extends Url
{
    const REGEX = '/mixcloud.com\/(?P<user>[^\/\?#]+)\/(?P<mix>[^\/\?#]+).*/';
    /**
     * @var string
     *
     * @ORM\Column(name="mixcloud_user", type="string", length=255, nullable=false)
     */
    protected $user;

    /**
     * @var string
     *
     * @ORM\Column(name="mixcloud_mix", type="string", length=255, nullable=false)
     */
    protected $mix;

    /**
     * Assembles the url back from components
     *
     * @return string
     */
    public function getUrl()
    {
        return sprintf('https://www.mixcloud.com/%s/%s/', $this->getUser(), $this->getMix());
    }

    /**
     * Sets the url components
     *
     * @param string $url
     *
     * @return bool|void
     */
    public function setUrl($url)
    {
        if (!preg_match(static::REGEX, $url, $matches)) {
            throw new \InvalidArgumentException("Invalid mixcloud url '$url'");
        }

        $this->setUser($matches['user']);
        $this->setMix($matches['mix']);
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
    public function getMix()
    {
        return $this->mix;
    }

    /**
     * @param string $mix
     */
    public function setMix($mix)
    {
        $this->mix = $mix;
    }
}
