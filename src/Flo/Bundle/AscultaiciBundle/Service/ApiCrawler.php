<?php
namespace Flo\Bundle\AscultaiciBundle\Service;

use Flo\Bundle\AscultaiciBundle\Entity\Url\Url;
use Flo\Bundle\AscultaiciBundle\Entity\Url\UrlMixcloud;
use Flo\Bundle\AscultaiciBundle\Entity\Url\UrlSoundcloud;
use Flo\Bundle\AscultaiciBundle\Entity\Url\UrlYoutube;
use Flo\Bundle\AscultaiciBundle\Service\Api\Adapter\ApiProviderInterface;

class ApiCrawler
{
    const OEMBED_YOUTUBE = 'http://www.youtube.com/oembed?format=json&url=%s';

    const OEMBED_SOUNDCLOUD = 'http://soundcloud.com/oembed?format=json&url=%s';

    const OEMBED_MIXCLOUD = 'https://www.mixcloud.com/oembed/?format=json&url=%s';

    /**
     * Looks up info about the $url
     *
     * @param Url $url
     *
     * @return mixed
     */
    public function oembedFill(Url $url)
    {
        try {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $url->getOembedUrl(),
                CURLOPT_USERAGENT => 'Ascultaici'
            ));
            $json = curl_exec($curl);
            curl_close($curl);
        }
        catch (\Exception $e) {
        }

        $array = json_decode($json, true);

        if (isset($array['title'])) {
            $url->setTitle($array['title']);
        }

        if (isset($array['author_name'])) {
            $url->setAuthorName($array['author_name']);
        }

        if (isset($array['author_url'])) {
            $url->setAuthorUrl($array['author_url']);
        }

        if ($url instanceof UrlYoutube) {
            if (isset($array['thumbnail_url'])) {
                $url->setThumbnailUrl($array['thumbnail_url']);
            }
        }

        if ($url instanceof UrlSoundcloud) {
            if (isset($array['description'])) {
                $url->setDescription($array['description']);
            }

            if (isset($array['thumbnail_url'])) {
                $url->setThumbnailUrl($array['thumbnail_url']);
            }
        }

        if ($url instanceof UrlMixcloud) {
            if (isset($array['image'])) {
                $url->setImageUrl($array['image']);
            }
        }

        return;
    }
}
