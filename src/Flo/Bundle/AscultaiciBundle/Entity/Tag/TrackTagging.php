<?php
namespace Flo\Bundle\AscultaiciBundle\Entity\Tag;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Flo\Bundle\AscultaiciBundle\Entity\Track;
use Flo\Bundle\AscultaiciBundle\Repository\Tag\TaggingRepository;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Flo\Bundle\AscultaiciBundle\Validator\Constraint as AscultAssert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * @ORM\Entity(repositoryClass="Flo\Bundle\AscultaiciBundle\Repository\Tag\TrackTaggingRepository")
 */
class TrackTagging extends Tagging
{
    /**
     * @var Track
     *
     * @ORM\ManyToOne(targetEntity="Flo\Bundle\AscultaiciBundle\Entity\Track", inversedBy="taggings")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="track_id", referencedColumnName="id", nullable=false)
     * })
     */
    protected $track;

    /**
     * @return Track
     */
    public function getTrack()
    {
        return $this->track;
    }

    /**
     * @param Track $track
     */
    public function setTrack($track)
    {
        $this->track = $track;
    }
}
