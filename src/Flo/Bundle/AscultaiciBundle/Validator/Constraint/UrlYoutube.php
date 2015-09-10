<?php
namespace Flo\Bundle\AscultaiciBundle\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UrlYoutube extends Constraint
{
    public $message = 'Not a valid Youtube url';

    public function validatedBy()
    {
        return 'url_youtube';
    }
}
