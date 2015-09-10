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
 * @ORM\Table(
 *   name="tagging",
 *   uniqueConstraints={@UniqueConstraint(name="tagging_unique",columns={"url_id", "tag_id", "type"})}
 * )
 *
 * @ORM\InheritanceType("SINGLE_TABLE")
 *
 * @ORM\DiscriminatorColumn(
 *   name="type",
 *   type="string",
 *   columnDefinition="ENUM(
     'Flo\Bundle\AscultaiciBundle\Repository\Tag\TaggingRepository::TYPE_SONG',
     'Flo\Bundle\AscultaiciBundle\Repository\Tag\TaggingRepository::TYPE_TRACK',
     'Flo\Bundle\AscultaiciBundle\Repository\Tag\TaggingRepository::TYPE_PLAYLIST'
 ) NOT NULL"
 * )
 *
 * @ORM\DiscriminatorMap({
 *   Flo\Bundle\AscultaiciBundle\Repository\Tag\TaggingRepository::TYPE_SONG = "Flo\Bundle\AscultaiciBundle\Entity\Tag\UrlTagging",
 *   Flo\Bundle\AscultaiciBundle\Repository\Tag\TaggingRepository::TYPE_TRACK = "Flo\Bundle\AscultaiciBundle\Entity\Tag\TrackTagging",
 *   Flo\Bundle\AscultaiciBundle\Repository\Tag\TaggingRepository::TYPE_PLAYLIST = "Flo\Bundle\AscultaiciBundle\Entity\Tag\PlaylistTagging"
 * })
 *
 * @ORM\Entity(repositoryClass="Flo\Bundle\AscultaiciBundle\Repository\Tag\TaggingRepository")
 */
abstract class Tagging
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
     * @var Tag
     *
     * @ORM\ManyToOne(targetEntity="Tag", inversedBy="taggings")
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
