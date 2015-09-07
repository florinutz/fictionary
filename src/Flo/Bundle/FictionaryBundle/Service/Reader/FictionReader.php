<?php
namespace Flo\Bundle\FictionaryBundle\Service\Reader;

use Flo\Bundle\FictionaryBundle\Entity\Fiction;
use Flo\Bundle\FictionaryBundle\Repository\FictionRepository;

class FictionReader
{
    /**
     * @var FictionRepository
     */
    protected $fictionRepository;

    /**
     * FictionReader constructor.
     *
     * @param FictionRepository $fictionRepository
     */
    public function __construct(FictionRepository $fictionRepository)
    {
        $this->fictionRepository = $fictionRepository;
    }

    /**
     * @param string $slug
     *
     * @return Fiction|null
     */
    public function findBySlug($slug)
    {
        return $this->fictionRepository->findOneBy(['slug' => $slug]);
    }

    /**
     * @return Fiction
     */
    public function getRandom()
    {
        return $this->fictionRepository->getRandom();
    }
}
