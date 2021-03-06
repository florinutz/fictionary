<?php
namespace Flo\Bundle\AscultaiciBundle\Entity\Url;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Flo\Bundle\AscultaiciBundle\Entity\Tag\UrlTagging;
use Flo\Bundle\AscultaiciBundle\Repository\Url\UrlRepository;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Flo\Bundle\AscultaiciBundle\Validator\Constraint as AscultAssert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Flo\Bundle\AscultaiciBundle\Entity\Tag\Tagging;
use Flo\Bundle\AscultaiciBundle\Entity\Track;

/**
 * @ORM\Table(name="url")
 *
 * @ORM\InheritanceType("SINGLE_TABLE")
 *
 * @ORM\DiscriminatorColumn(name="type", type="string", columnDefinition="ENUM('youtube', 'soundcloud', 'mixcloud') NOT NULL")
 *
 * @ORM\DiscriminatorMap({
 *   "youtube" = "Flo\Bundle\AscultaiciBundle\Entity\Url\UrlYoutube",
 *   "soundcloud" = "Flo\Bundle\AscultaiciBundle\Entity\Url\UrlSoundcloud",
 *   "mixcloud" = "Flo\Bundle\AscultaiciBundle\Entity\Url\UrlMixcloud"
 * })
 *
 * @ORM\Entity(
 *   repositoryClass="Flo\Bundle\AscultaiciBundle\Repository\Url\UrlRepository"
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
     * @ORM\OneToMany(targetEntity="Flo\Bundle\AscultaiciBundle\Entity\Track", mappedBy="url")
     */
    protected $tracks;

    /**
     * @var ArrayCollection|UrlTagging[]
     *
     * @ORM\OneToMany(targetEntity="Flo\Bundle\AscultaiciBundle\Entity\Tag\UrlTagging", mappedBy="url")
     */
    protected $taggings;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    protected $title;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"title"}, updatable=false, unique=true, separator="-", style="lower")
     * @ORM\Column(length=128, unique=true, nullable=true)
     */
    protected $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="author_name", type="string", length=255, nullable=true)
     */
    protected $authorName;

    /**
     * @var string
     *
     * @ORM\Column(name="author_url", type="string", length=255, nullable=true)
     */
    protected $authorUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="thumbnail_url", type="string", length=255, nullable=true)
     */
    protected $thumbnailUrl;

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
     * @ORM\Column(name="length", type="integer", nullable=true)
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

    /**
     * Assembles the url back from components
     *
     * @return string
     */
    abstract public function getUrl();

    /**
     * Splits the url into components
     *
     * @param string $url
     */
    abstract public function setUrl($url);

    /**
     * @return string
     */
    abstract public function getOembedUrl();


    public function __construct()
    {
        $this->tracks = $this->taggings = new ArrayCollection;
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
     * @return string
     */
    public function getAuthorName()
    {
        return $this->authorName;
    }

    /**
     * @param string $authorName
     */
    public function setAuthorName($authorName)
    {
        $this->authorName = $authorName;
    }

    /**
     * @return string
     */
    public function getAuthorUrl()
    {
        return $this->authorUrl;
    }

    /**
     * @param string $authorUrl
     */
    public function setAuthorUrl($authorUrl)
    {
        $this->authorUrl = $authorUrl;
    }

    /**
     * @return string
     */
    public function getThumbnailUrl()
    {
        return $this->thumbnailUrl;
    }

    /**
     * @param string $thumbnailUrl
     */
    public function setThumbnailUrl($thumbnailUrl)
    {
        $this->thumbnailUrl = $thumbnailUrl;
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
     * @param UrlTagging $tagging
     */
    public function addTagging(UrlTagging $tagging)
    {
        $this->taggings[] = $tagging;
    }

    /**
     * @param UrlTagging $tagging
     */
    public function removeTagging(UrlTagging $tagging)
    {
        $this->taggings->removeElement($tagging);
    }

    /**
     * @return ArrayCollection|UrlTagging[]
     */
    public function getTaggings()
    {
        return $this->taggings;
    }

    /**
     * @return string the type
     */
    public function getType()
    {
        if ($this instanceof UrlYoutube) {
            return UrlRepository::TYPE_YOUTUBE;
        }
        if ($this instanceof UrlSoundcloud) {
            return UrlRepository::TYPE_SOUNDCLOUD;
        }
        if ($this instanceof UrlMixcloud) {
            return UrlRepository::TYPE_MIXCLOUD;
        }

        throw new \LogicException('Url type not (currently?) supported');
    }
}
