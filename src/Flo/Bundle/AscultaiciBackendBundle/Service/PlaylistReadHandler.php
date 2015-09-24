<?php
namespace Flo\Bundle\AscultaiciBackendBundle\Service;

use Doctrine\ORM\EntityManager;
use Flo\Bundle\AscultaiciBundle\Entity\Playlist;
use Flo\Bundle\AscultaiciBundle\Repository\PlaylistRepository;
use Flo\Bundle\AscultaiciBundle\Service\AbstractReadHandler;
use Flo\Bundle\UserBundle\Entity\User;

class PlaylistReadHandler extends AbstractReadHandler
{
    /**
     * @var PlaylistRepository
     */
    protected $playlistRepository;

    /**
     * @param EntityManager $manager
     * @param PlaylistRepository $playlistRepository
     */
    public function __construct(EntityManager $manager, PlaylistRepository $playlistRepository)
    {
        parent::__construct($manager);
        $this->playlistRepository = $playlistRepository;
    }

    /**
     * @param int|User $user
     * @param string $slug
     *
     * @return Playlist|null
     */
    public function findOneWithTracks($user, $slug)
    {
        return $this->playlistRepository->findOneWithTracks($user, $slug);
    }

    /**
     * @param User|int $user
     *
     * @return Playlist[]
     */
    public function findByUser($user)
    {
        return $this->playlistRepository->findBy(['createdBy' => $user]);
    }
}
