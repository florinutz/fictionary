<?php
namespace Flo\Bundle\AscultaiciBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Flo\Bundle\AscultaiciBundle\Entity\Tag\TrackTagging;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Flo\Bundle\AscultaiciBundle\Validator\Constraint as AscultAssert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Flo\Bundle\AscultaiciBundle\Entity\Url\Url;

/**
 * @ORM\Table(name="track")
 *
 * @ORM\Entity(repositoryClass="Flo\Bundle\AscultaiciBundle\Repository\TrackRepository")
 *
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class Track
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
     * @ORM\ManyToOne(targetEntity="Flo\Bundle\AscultaiciBundle\Entity\Url\Url", inversedBy="tracks")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="url_id", referencedColumnName="id", nullable=false)
     * })
     */
    protected $url;

    /**
     * @var Playlist
     *
     * @ORM\ManyToOne(targetEntity="Playlist", inversedBy="tracks")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="playlist_id", referencedColumnName="id", nullable=false)
     * })
     */
    protected $playlist;

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
     * @Assert\GreaterThanOrEqual(value=0)
     *
     * @ORM\Column(name="start", type="integer", nullable=true)
     */
    protected $start = 0;

    /**
     * @var int
     *
     * @Assert\GreaterThan(value=0)
     *
     * @ORM\Column(name="stop", type="integer", nullable=true)
     */
    protected $stop;

    /**
     * @var ArrayCollection|TrackTagging[]
     *
     * @ORM\OneToMany(targetEntity="Flo\Bundle\AscultaiciBundle\Entity\Tag\TrackTagging", mappedBy="track")
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


    public function __construct()
    {
        $this->taggings = new ArrayCollection;
    }


    /**
     * @Assert\Callback
     */
    public function validateInterval(ExecutionContextInterface $context)
    {
        if ($this->getStop()) {
            $dif = $this->getStop() - $this->getStart();
            if ($dif < 2) { // min 2 seconds per track
                $context->buildViolation('Invalid stop time')
                    ->atPath('stop')
                    ->addViolation()
                ;
            }
        }
    }


    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Url $url
     * @return Track
     */
    public function setUrl(Url $url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return Url
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param Playlist $playlist
     * @return Track
     */
    public function setPlaylist(Playlist $playlist)
    {
        $this->playlist = $playlist;

        return $this;
    }

    /**
     * @return Playlist
     */
    public function getPlaylist()
    {
        return $this->playlist;
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
     * @return int
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @param int $start
     */
    public function setStart($start)
    {
        $this->start = $start;
    }

    /**
     * @return int
     */
    public function getStop()
    {
        return $this->stop;
    }

    /**
     * @param int $stop
     */
    public function setStop($stop)
    {
        $this->stop = $stop;
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
     * @param TrackTagging $tagging
     */
    public function addTagging(TrackTagging $tagging)
    {
        $this->taggings[] = $tagging;
    }

    /**
     * @param TrackTagging $tagging
     */
    public function removeTagging(TrackTagging $tagging)
    {
        $this->taggings->removeElement($tagging);
    }

    /**
     * @return ArrayCollection|TrackTagging[]
     */
    public function getTaggings()
    {
        return $this->taggings;
    }
}
