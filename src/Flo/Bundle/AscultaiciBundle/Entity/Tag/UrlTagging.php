<?php
namespace Flo\Bundle\AscultaiciBundle\Entity\Tag;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Flo\Bundle\AscultaiciBundle\Repository\Tag\TaggingRepository;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Flo\Bundle\AscultaiciBundle\Validator\Constraint as AscultAssert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Flo\Bundle\AscultaiciBundle\Entity\Url\Url;

/**
 * @ORM\Entity(repositoryClass="Flo\Bundle\AscultaiciBundle\Repository\Tag\UrlTaggingRepository")
 */
class UrlTagging extends Tagging
{
    /**
     * @var Url
     *
     * @ORM\ManyToOne(targetEntity="Flo\Bundle\AscultaiciBundle\Entity\Url\Url", inversedBy="taggings")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="url_id", referencedColumnName="id", nullable=false)
     * })
     */
    protected $url;

    /**
     * @param Url $url
     */
    public function setUrl(Url $url)
    {
        $this->url = $url;
    }

    /**
     * @return Url
     */
    public function getUrl()
    {
        return $this->url;
    }
}
