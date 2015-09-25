<?php
namespace Flo\Bundle\AscultaiciBundle\Tests\Service;

use Flo\Bundle\AscultaiciBundle\Entity\Url\UrlMixcloud;
use Flo\Bundle\AscultaiciBundle\Entity\Url\UrlSoundcloud;
use Flo\Bundle\AscultaiciBundle\Entity\Url\UrlYoutube;
use Flo\Bundle\AscultaiciBundle\Repository\Url\UrlRepository;
use Flo\Bundle\AscultaiciBundle\Service\UrlFactory;

class UrlFactoryTest extends \PHPUnit_Framework_TestCase
{
    protected $urlYoutube = 'https://www.youtube.com/watch?v=_zpOc9n7dlI';
    protected $urlSoundcloud = 'https://soundcloud.com/uprootandy/homenaje-a-justino-uproot-andy';
    protected $urlMixcloud = 'https://www.mixcloud.com/mrLob/45-funk-mix-live/';

    /**
     * Tests the type check
     */
    public function testGetType()
    {
        $type = UrlRepository::getType($this->urlYoutube);
        $this->assertTrue($type == UrlRepository::TYPE_YOUTUBE, 'Youtube type not recognized');

        $type = UrlRepository::getType($this->urlSoundcloud);
        $this->assertTrue($type == UrlRepository::TYPE_SOUNDCLOUD, 'Soundcloud type not recognized');

        $type = UrlRepository::getType($this->urlMixcloud);
        $this->assertTrue($type == UrlRepository::TYPE_MIXCLOUD, 'Mixcloud type not recognized');
    }

    /**
     * Tests generated instances
     */
    public function testGenerate()
    {
        $youtubeUrl = UrlFactory::generate($this->urlYoutube);
        $this->assertTrue($youtubeUrl instanceof UrlYoutube, 'Wrong type for youtube url instance');

        $soundcloudUrl = UrlFactory::generate($this->urlSoundcloud);
        $this->assertTrue($soundcloudUrl instanceof UrlSoundcloud, 'Wrong type for soundcloud url instance');

        $mixcloudUrl = UrlFactory::generate($this->urlMixcloud);
        $this->assertTrue($mixcloudUrl instanceof UrlMixcloud, 'Wrong type for mixcloud url instance');
    }
}
