<?php
namespace Flo\Bundle\AscultaiciBundle\Entity\Tag;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Flo\Bundle\AscultaiciBundle\Validator\Constraint as AscultAssert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Table(name="tag")
 *
 * @ORM\Entity(repositoryClass="Flo\Bundle\AscultaiciBundle\Repository\Tag\TagRepository")
 *
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class Tag
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    protected $name;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"name"}, updatable=false, unique=true, separator="-", style="lower")
     * @ORM\Column(name="slug", length=128, unique=true)
     */
    protected $slug;

    /**
     * @var int
     *
     * @Assert\GreaterThanOrEqual(value=0)
     *
     * @ORM\Column(name="count_urls", type="integer", nullable=true)
     */
    protected $countUrls = 0;

    /**
     * @var int
     *
     * @Assert\GreaterThanOrEqual(value=0)
     *
     * @ORM\Column(name="count_tracks", type="integer", nullable=true)
     */
    protected $countTracks = 0;

    /**
     * @var ArrayCollection|Tagging[]
     *
     * @ORM\OneToMany(targetEntity="Tagging", mappedBy="tag")
     */
    protected $taggings;

    /**
     * @var \DateTime
     *
     * @Assert\Type("\DateTime")
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;


    public function __construct()
    {
        $this->taggings = new ArrayCollection;
    }


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return int
     */
    public function getCountUrls()
    {
        return $this->countUrls;
    }

    /**
     * @param int $countUrls
     */
    public function setCountUrls($countUrls)
    {
        $this->countUrls = $countUrls;
    }

    /**
     * @return int
     */
    public function getCountTracks()
    {
        return $this->countTracks;
    }

    /**
     * @param int $countTracks
     */
    public function setCountTracks($countTracks)
    {
        $this->countTracks = $countTracks;
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
     * @param Tagging $tagging
     */
    public function addTagging(Tagging $tagging)
    {
        $this->taggings[] = $tagging;
    }

    /**
     * @param Tagging $tagging
     */
    public function removeTagging(Tagging $tagging)
    {
        $this->taggings->removeElement($tagging);
    }

    /**
     * @return ArrayCollection|Tagging[]
     */
    public function getTaggings()
    {
        return $this->taggings;
    }
}
