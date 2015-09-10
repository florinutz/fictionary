<?php
namespace Flo\Bundle\AscultaiciBundle\Service\Api\Adapter;

/**
 * All Crawl adapters should implement this one
 */
interface ApiProviderInterface
{
    /**
     * @param string $url
     *
     * @return mixed
     */
    public function oembed($url);
}
