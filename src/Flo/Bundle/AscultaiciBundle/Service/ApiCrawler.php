<?php
namespace Flo\Bundle\AscultaiciBundle\Service;

use Flo\Bundle\AscultaiciBundle\Entity\Song;
use Flo\Bundle\AscultaiciBundle\Exception\InvalidTypeException;
use Flo\Bundle\AscultaiciBundle\Repository\SongRepository;
use Flo\Bundle\AscultaiciBundle\Service\Api\Adapter\ApiProviderInterface;

class ApiCrawler
{
    // http://www.youtube.com/oembed?url=https://www.youtube.com/watch?v=2Iueu1944TY&format=json
    // http://soundcloud.com/oembed?format=json&url=http://soundcloud.com/forss/flickermood
    // https://www.mixcloud.com/oembed/?url=https%3A//www.mixcloud.com/spartacus/party-time/&format=json

    /**
     * @var SongRepository
     */
    protected $songRepo;

    /**
     * @param SongRepository $songRepo
     */
    public function __construct(SongRepository $songRepo)
    {
        $this->songRepo = $songRepo;
    }


    /**
     * Looks up for info about the $song
     *
     * @param Song $song
     *
     * @return mixed
     */
    public function lookUp(Song $song)
    {
        $url = $song->getUrl();
        $parser = $this->getApiParserFor($url);

        return $parser->oembed($url);
    }

    /**
     * @param string $sourceUrl
     *
     * @return ApiProviderInterface
     */
    protected function getApiParserFor($sourceUrl)
    {
        //$type = $this->getType($sourceUrl);
    }

    protected function getType($sourceUrl)
    {
        $map = [
            'youtube.com' => static::TYPE_YOUTUBE,
            'soundcloud.com' => static::TYPE_SOUNDCLOUD,
            'mixcloud.com' => static::TYPE_MIXCLOUD
        ];

        $host = parse_url($sourceUrl, PHP_URL_HOST);

        if (!array_key_exists($host, $map)) {
            throw new InvalidTypeException("Unknown host $host");
        }

        return $map[$host];
    }
}
