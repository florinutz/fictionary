<?php
namespace Flo\Bundle\AscultaiciBackendBundle\Service;

use Doctrine\ORM\EntityManager;
use Flo\Bundle\AscultaiciBundle\Entity\Url\Url;
use Flo\Bundle\AscultaiciBundle\Repository\Url\UrlRepository;
use Flo\Bundle\AscultaiciBundle\Service\AbstractReadHandler;

class UrlReadHandler extends AbstractReadHandler
{
    /**
     * @var UrlRepository
     */
    protected $urlRepository;

    /**
     * @param EntityManager $manager
     * @param UrlRepository $urlRepository
     */
    public function __construct(
        EntityManager $manager,
        UrlRepository $urlRepository
    ) {
        parent::__construct($manager);
        $this->urlRepository = $urlRepository;
    }

    /**
     * @param $id
     *
     * @return null|Url
     */
    public function find($id)
    {
        return $this->urlRepository->find($id);
    }

    /**
     * @param $urlString
     *
     * @return null|Url
     */
    public function findOneByUrl($urlString)
    {
        return $this->urlRepository->findOneBy(['url' => $urlString]);
    }
}
