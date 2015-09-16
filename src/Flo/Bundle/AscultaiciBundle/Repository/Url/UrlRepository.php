<?php
namespace Flo\Bundle\AscultaiciBundle\Repository\Url;

use Doctrine\ORM\EntityRepository;
use Flo\Bundle\AscultaiciBundle\Entity\Url\Url;

class UrlRepository extends EntityRepository
{
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
