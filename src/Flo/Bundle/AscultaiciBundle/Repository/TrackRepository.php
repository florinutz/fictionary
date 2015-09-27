<?php
namespace Flo\Bundle\AscultaiciBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Flo\Bundle\AscultaiciBundle\Entity\Playlist;
use Flo\Bundle\AscultaiciBundle\Entity\Track;
use Flo\Bundle\AscultaiciBundle\Entity\Url\Url;
use Flo\Bundle\UserBundle\Entity\User;

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
     * @param string $playlistSlug
     * @param string $trackSlug
     *
     * @return Track|null
     *
     */
    public function findWithUrlAndTags($playlistSlug, $trackSlug)
    {
        $builder = $this->createQueryBuilder('track')
            ->select('track', 'playlist', 'url', 'taggings', 'tag')
            ->join('track.url', 'url')
            ->join('track.playlist', 'playlist')
            ->leftJoin('track.taggings', 'taggings')
            ->leftJoin('taggings.tag', 'tag')

            ->where('track.slug = :trackSlug')
            ->andWhere('playlist.slug = :playlistSlug')

            ->setParameters([
                'playlistSlug' => $playlistSlug,
                'trackSlug' => $trackSlug
            ])
        ;

        return $builder->getQuery()->getOneOrNullResult();
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
