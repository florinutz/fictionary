<?php
namespace Flo\Bundle\AscultaiciBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Flo\Bundle\AscultaiciBundle\Entity\Playlist;
use Flo\Bundle\UserBundle\Entity\User;

class PlaylistRepository extends EntityRepository
{
    /**
     * @param int|User $user
     * @param $slug
     * @return Playlist|null
     *
     */
    public function findOneWithTracks($user, $slug)
    {
        $builder = $this->createQueryBuilder('playlist')
            ->select('playlist', 'tracks', 'urls', 'taggings', 'tags')

            ->leftJoin('playlist.tracks', 'tracks')
            ->leftJoin('tracks.url', 'urls')
            ->leftJoin('tracks.taggings', 'taggings')
            ->leftJoin('taggings.tag', 'tags')

            ->where('playlist.slug = :slug')
            ->andWhere('playlist.createdBy = :user')

            ->setParameters(['user' => $user->getId(), 'slug' => $slug])
        ;

        return $builder->getQuery()->getOneOrNullResult();
    }

    /**
     * @param Playlist $playlist
     */
    public function delete(Playlist $playlist)
    {
        $this->getEntityManager()->remove($playlist);
        $this->getEntityManager()->flush($playlist);
    }

}
