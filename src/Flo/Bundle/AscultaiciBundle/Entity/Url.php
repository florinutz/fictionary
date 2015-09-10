<?php

namespace Flo\Bundle\AscultaiciBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Flo\Bundle\AscultaiciBundle\Validator\Constraint as AscultAssert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Table(name="url")
 *
 * @ORM\InheritanceType("SINGLE_TABLE")
 *
 * @ORM\DiscriminatorColumn(
 *   name="type",
 *   type="string",
 *   columnDefinition="ENUM('youtube', 'soundcloud', 'mixcloud') NOT NULL"
 * )
 *
 * @ORM\DiscriminatorMap({
 *   "youtube" = "Flo\Bundle\AscultaiciBundle\Entity\UrlYoutube",
 *   "soundcloud" = "Flo\Bundle\AscultaiciBundle\Entity\UrlSoundcloud",
 *   "mixcloud" = "Flo\Bundle\AscultaiciBundle\Entity\UrlMixcloud"
 * })
 *
 * @ORM\Entity(
 *   repositoryClass="Flo\Bundle\AscultaiciBundle\Repository\UrlRepository"
 * )
 *
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
abstract class Url
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
     * @var ArrayCollection|Track[]
     *
     * @ORM\OneToMany(targetEntity="Track", mappedBy="url")
     */
    protected $tracks;

    /**
     * @var ArrayCollection|UrlToTag[]
     *
     * @ORM\OneToMany(targetEntity="UrlToTag", mappedBy="url")
     */
    protected $urlToTags;

    /**
     * @var string
     *
     * @AscultAssert\UrlYoutube
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=false)
     */
    protected $url;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    protected $title;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"title"}, updatable=false, unique=true, separator="-", style="lower")
     * @ORM\Column(length=128, unique=true)
     */
    protected $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    protected $description;

    /**
     * @var int
     *
     * @Assert\GreaterThan(value=0)
     *
     * @ORM\Column(name="length", type="integer", nullable=false)
     */
    protected $length;

    /**
     * @var \DateTime
     *
     * @Assert\Type("\DateTime")
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * @var \DateTime $deletedAt
     *
     * @Assert\Type("\DateTime")
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    protected $deletedAt;

    /**
     * @var \DateTime $updatedAt
     *
     * @Assert\Type("\DateTime")
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     */
    protected $updatedAt;


    public function __construct()
    {
        $this->tracks = new ArrayCollection;
        $this->urlToTags = new ArrayCollection;
    }


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * @param \DateTime $deletedAt
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Set source
     *
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Get source
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }


    /**
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param int $length
     */
    public function setLength($length)
    {
        $this->length = $length;
    }

    /**
     * @param Track $tracks
     *
     * @return Url
     */
    public function addTrack(Track $tracks)
    {
        $this->tracks[] = $tracks;
    }

    /**
     * @param Track $tracks
     */
    public function removeTrack(Track $tracks)
    {
        $this->tracks->removeElement($tracks);
    }

    /**
     * @return ArrayCollection|Track[]
     */
    public function getTracks()
    {
        return $this->tracks;
    }

    /**
     * @param UrlToTag $urlToTags
     */
    public function addUrlToTag(UrlToTag $urlToTags)
    {
        $this->urlToTags[] = $urlToTags;
    }

    /**
     * @param UrlToTag $urlToTags
     */
    public function removeUrlToTag(UrlToTag $urlToTags)
    {
        $this->urlToTags->removeElement($urlToTags);
    }

    /**
     * @return ArrayCollection|UrlToTag[]
     */
    public function getUrlToTags()
    {
        return $this->urlToTags;
    }
}
