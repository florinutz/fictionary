<?php
namespace Flo\Bundle\AscultaiciBundle\Repository\Url;

use Doctrine\ORM\EntityRepository;
use Flo\Bundle\AscultaiciBundle\Entity\Url\Url;
use Flo\Bundle\AscultaiciBundle\Entity\Url\UrlSoundcloud;

class UrlSoundcloudRepository extends UrlRepository
{
    /**
     * @param Url|UrlSoundcloud $url
     *
     * @return array
     */
    public function getIdentifyingArray(Url $url)
    {
        return [
            'user' => $url->getUser(),
            'track' => $url->getTrack()
        ];
    }
}
