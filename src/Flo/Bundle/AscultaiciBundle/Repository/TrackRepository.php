<?php
namespace Flo\Bundle\AscultaiciBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Flo\Bundle\AscultaiciBundle\Entity\Playlist;
use Flo\Bundle\AscultaiciBundle\Entity\Track;
use Flo\Bundle\AscultaiciBundle\Entity\Url\Url;

class TrackRepository extends EntityRepository
{
    /**
     * @param int|Url $url
     * @param int|Playlist $playlist
     *
     * @return null|Track
     */
    public function findOneByUrlAndPlaylist($url, $playlist)
    {
        return $this->findOneBy(['url' => $url, 'playlist' => $playlist]);
    }

    /**
     * @param int $id
     *
     * @return Track
     */
    public function findWithUrl($id)
    {
    }
}
