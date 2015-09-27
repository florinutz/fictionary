<?php
namespace Flo\Bundle\AscultaiciBackendBundle\Service\Doctrine\Event;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Flo\Bundle\AscultaiciBundle\Entity\Track;
use Flo\Bundle\AscultaiciBundle\Entity\Url\Url;
use Flo\Bundle\AscultaiciBundle\Service\ApiCrawler;

class CrawlerSubscriber implements EventSubscriber
{
    /**
     * @var ApiCrawler
     */
    protected $crawler;

    /**
     * @param ApiCrawler $crawler
     */
    public function __construct(ApiCrawler $crawler)
    {
        $this->crawler = $crawler;
    }

    public function getSubscribedEvents()
    {
        return ['prePersist'];
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof Url) {
            $this->crawler->oembedFill($entity);
        }
        if ($entity instanceof Track) {
            if (!$entity->getTitle()) {
                $entity->setTitle($entity->getUrl()->getTitle());
            }
        }
    }

}
