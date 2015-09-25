<?php
namespace Flo\Bundle\AscultaiciBundle\Repository\Url;

use Flo\Bundle\AscultaiciBundle\Entity\Url\Url;
use Flo\Bundle\AscultaiciBundle\Entity\Url\UrlMixcloud;

class UrlMixcloudRepository extends UrlRepository
{
    /**
     * @param Url|UrlMixcloud $url
     *
     * @return array
     */
    public function getIdentifyingArray(Url $url)
    {
        return [
            'user' => $url->getUser(),
            'mix' => $url->getMix()
        ];
    }
}
