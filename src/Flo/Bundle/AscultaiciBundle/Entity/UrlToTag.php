<?php

namespace Flo\Bundle\AscultaiciBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Flo\Bundle\AscultaiciBundle\Validator\Constraint as AscultAssert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * @ORM\Table(
 *   name="url_to_tag",
 *   uniqueConstraints={@UniqueConstraint(name="url_tag_unique",columns={"url_id", "tag_id"})}
 * )
 *
 * @ORM\Entity(repositoryClass="Flo\Bundle\AscultaiciBundle\Repository\UrlRepository")
 */
class UrlToTag
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Url
     *
     * @ORM\ManyToOne(targetEntity="Url", inversedBy="urlToTags")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="url_id", referencedColumnName="id", nullable=false)
     * })
     */
    protected $url;

    /**
     * @var Tag
     *
     * @ORM\ManyToOne(targetEntity="Tag", inversedBy="tagToUrls")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tag_id", referencedColumnName="id", nullable=false)
     * })
     */
    protected $tag;


    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

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

    /**
     * @param Tag $tag
     */
    public function setTag(Tag $tag)
    {
        $this->tag = $tag;
    }

    /**
     * @return Tag
     */
    public function getTag()
    {
        return $this->tag;
    }
}
