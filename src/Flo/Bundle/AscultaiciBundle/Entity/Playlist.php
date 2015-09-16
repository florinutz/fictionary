<?php
namespace Flo\Bundle\AscultaiciBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Flo\Bundle\AscultaiciBundle\Entity\Tag\PlaylistTagging;
use Flo\Bundle\AscultaiciBundle\Entity\Url\Url;
use Flo\Bundle\AscultaiciBundle\FloAscultaiciBundle;
use Flo\Bundle\UserBundle\Entity\User;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Flo\Bundle\AscultaiciBundle\Validator\Constraint as AscultAssert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Table(name="playlist")
 *
 * @ORM\Entity(repositoryClass="Flo\Bundle\AscultaiciBundle\Repository\PlaylistRepository")
 *
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class Playlist
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
     * @var ArrayCollection|Track[]
     *
     * @ORM\OneToMany(targetEntity="Track", mappedBy="playlist")
     */
    protected $tracks;

    /**
     * @var ArrayCollection|PlaylistTagging[]
     *
     * @ORM\OneToMany(targetEntity="Flo\Bundle\AscultaiciBundle\Entity\Tag\PlaylistTagging", mappedBy="playlist")
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
     * @var User
     *
     * @Gedmo\Blameable(on="create")
     *
     * @ORM\ManyToOne(targetEntity="Flo\Bundle\UserBundle\Entity\User", inversedBy="playlists")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id", nullable=false)
     */
    protected $createdBy;

    /**
     * @var User
     *
     * @Gedmo\Blameable(on="update")
     *
     * @ORM\ManyToOne(targetEntity="Flo\Bundle\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="updated_by", referencedColumnName="id", nullable=true)
     */
    protected $updatedBy;


    public function __construct()
    {
        $this->tracks = $this->taggings = new ArrayCollection;
    }

    /**
     * Get id
     *
     * @return integer
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
     * @param PlaylistTagging $tagging
     */
    public function addTagging(PlaylistTagging $tagging)
    {
        $this->taggings[] = $tagging;
    }

    /**
     * @param PlaylistTagging $tagging
     */
    public function removeTagging(PlaylistTagging $tagging)
    {
        $this->taggings->removeElement($tagging);
    }

    /**
     * @return ArrayCollection|PlaylistTagging[]
     */
    public function getTaggings()
    {
        return $this->taggings;
    }

    /**
     * @return User
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param User $createdBy
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
    }

    /**
     * @return User
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     * @param User $updatedBy
     */
    public function setUpdatedBy($updatedBy)
    {
        $this->updatedBy = $updatedBy;
    }

}
