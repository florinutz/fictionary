<?php
namespace Flo\Bundle\AscultaiciBundle\Repository\Tag;

use Doctrine\ORM\EntityRepository;
use Flo\Bundle\AscultaiciBundle\Entity\Tag;

class TaggingRepository extends EntityRepository
{
    const TYPE_SONG = 'song';
    const TYPE_TRACK = 'track';
    const TYPE_PLAYLIST = 'playlist';

    /**
     * @var array
     */
    public static $types = [ self::TYPE_SONG, self::TYPE_TRACK, self::TYPE_PLAYLIST ];
}
