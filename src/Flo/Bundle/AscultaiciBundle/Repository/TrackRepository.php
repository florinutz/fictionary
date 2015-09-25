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
     * @param int $id Track id
     *
     * @return Track|null
     */
    public function findWithUrlAndTags($id)
    {
        $builder = $this->createQueryBuilder('track')
            ->select('track', 'url', 'taggings', 'tag')
            ->join('track.url', 'url')
            ->join('track.taggings', 'taggings')
            ->join('taggings.tag', 'tag')
            ->where('track.id = :id')
            ->setParameter('id', $id)
        ;

        return $builder->getQuery()->getResult();
    }

    /**
     * @param Playlist|int $playlist
     */
    public function deletePlaylistTracks($playlist)
    {
        return $this->getEntityManager()->createQueryBuilder()
            ->delete('FloAscultaiciBundle:Track', 'track')
            ->where('track.playlist = :playlist')
            ->getQuery()
            ->execute(['playlist' => $playlist])
        ;
    }
}
