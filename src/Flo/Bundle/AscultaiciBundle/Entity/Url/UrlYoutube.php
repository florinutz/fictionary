<?php

namespace Flo\Bundle\AscultaiciBundle\Entity\Url;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Flo\Bundle\AscultaiciBundle\Validator\Constraint as AscultAssert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Entity(repositoryClass="Flo\Bundle\AscultaiciBundle\Repository\Url\UrlYoutubeRepository")
 */
class UrlYoutube extends Url
{
    const REGEX = '/youtube.com\/watch\?(.*&)?v=(?P<id>[^&#\/]+)/i';
    /**
     * @var string
     *
     * @ORM\Column(name="youtube_identifier", type="string", length=255, nullable=false, unique=true)
     */
    protected $identifier;

    /**
     * Assembles the url back from components
     *
     * @return string
     */
    public function getUrl()
    {
        return sprintf('https://www.youtube.com/watch?v=%s', $this->getIdentifier());
    }

    /**
     * Splits the url into components
     *
     * @param string $url
     */
    public function setUrl($url)
    {
        if (!preg_match(static::REGEX, $url, $matches)) {
            throw new \InvalidArgumentException("Invalid youtube url '$url'");
        }

        $this->setIdentifier($matches['id']);
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @param string $identifier
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }
}
