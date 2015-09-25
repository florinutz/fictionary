<?php
namespace Flo\Bundle\AscultaiciBundle\Repository\Url;

use Flo\Bundle\AscultaiciBundle\Entity\Url\Url;
use Flo\Bundle\AscultaiciBundle\Entity\Url\UrlYoutube;

class UrlYoutubeRepository extends UrlRepository
{
    /**
     * @param Url|UrlYoutube $url
     * @return array
     */
    public function getIdentifyingArray(Url $url)
    {
        return ['identifier' => $url->getIdentifier()];
    }
}
