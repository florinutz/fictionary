<?php
namespace Flo\Bundle\AscultaiciBundle\Repository\Url;

use Doctrine\ORM\EntityRepository;
use Flo\Bundle\AscultaiciBundle\Entity\Url\Url;

class UrlRepository extends EntityRepository
{
    const TYPE_YOUTUBE = 'youtube';
    const TYPE_SOUNDCLOUD = 'soundcloud';
    const TYPE_MIXCLOUD = 'mixcloud';

    /**
     * @param string $url
     *
     * @return Url
     */
    public function findOneOrCreate($url)
    {
        if ($found = $this->findOneBy(['url' => $url])) {
            return $found;
        }

        // $new =
    }

    public function create($url)
    {
        //
    }
}
