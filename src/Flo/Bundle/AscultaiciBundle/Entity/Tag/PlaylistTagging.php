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
use Flo\Bundle\AscultaiciBundle\Entity\Playlist;

/**
 * @ORM\Entity(repositoryClass="Flo\Bundle\AscultaiciBundle\Repository\Tag\PlaylistTaggingRepository")
 */
class PlaylistTagging extends Tagging
{
    /**
     * @var Playlist
     *
     * @ORM\ManyToOne(targetEntity="Flo\Bundle\AscultaiciBundle\Entity\Playlist", inversedBy="taggings")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="playlist_id", referencedColumnName="id", nullable=false)
     * })
     */
    protected $playlist;

    /**
     * @return Playlist
     */
    public function getPlaylist()
    {
        return $this->playlist;
    }

    /**
     * @param Playlist $playlist
     */
    public function setPlaylist($playlist)
    {
        $this->playlist = $playlist;
    }
}
