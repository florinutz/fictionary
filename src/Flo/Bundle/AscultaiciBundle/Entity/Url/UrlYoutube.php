<?php

namespace Flo\Bundle\AscultaiciBundle\Entity\Url;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Flo\Bundle\AscultaiciBundle\Validator\Constraint as AscultAssert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Entity(repositoryClass="Flo\Bundle\AscultaiciBundle\Repository\Url\UrlYoutubeRepository")
 */
class UrlYoutube extends Url
{
}
