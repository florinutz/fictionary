<?php
namespace Flo\Bundle\AscultaiciBackendBundle\Form\DataTransformer;

use Flo\Bundle\AscultaiciBackendBundle\Service\UrlReadHandler;
use Flo\Bundle\AscultaiciBackendBundle\Service\UrlSaveHandler;
use Flo\Bundle\AscultaiciBundle\Entity\Url\Url;
use Flo\Bundle\AscultaiciBundle\Repository\Url\UrlRepository;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class UrlToIdTransformer implements DataTransformerInterface
{
    /**
     * @var UrlReadHandler
     */
    private $urlReadHandler;

    /**
     * @var UrlSaveHandler
     */
    private $urlSaveHandler;

    public function __construct(UrlReadHandler $urlReadHandler, UrlSaveHandler $urlSaveHandler)
    {
        $this->urlReadHandler = $urlReadHandler;
        $this->urlSaveHandler = $urlSaveHandler;
    }

    /**
     * Transforms an object (issue) to an id.
     *
     * @param  Url|null $url
     *
     * @return string|null
     */
    public function transform($url)
    {
        if (null === $url) {
            return null;
        }

        return $url->getUrl();
    }

    /**
     * Transforms a string (id) to an object (url).
     *
     * @param  string $urlString
     *
     * @return Url|null
     *
     * @throws TransformationFailedException if object (url) is not found.
     */
    public function reverseTransform($urlString)
    {
        if (!$urlString) {
            return null;
        }

        $url = $this->urlReadHandler->findOneByUrl($urlString);

        if (!$url) {
            //$this->urlSaveHandler->create($urlString);
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            //throw new TransformationFailedException(sprintf(
            //    'An url with number "%s" does not exist!',
            //    $urlString
            //));
        }

        return $url;
    }
}
