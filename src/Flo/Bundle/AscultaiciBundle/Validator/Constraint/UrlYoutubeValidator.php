<?php
namespace Flo\Bundle\AscultaiciBundle\Validator\Constraint;

use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class UrlYoutubeValidator extends ConstraintValidator
{
    const PATTERN = '~
        ^(?:https?://)?              # Optional protocol
         (?:www\.)?                  # Optional subdomain
         (?:youtube\.com|youtu\.be)  # Mandatory domain name
         /watch\?v=([^&]+)           # URI with video id as capture group 1
     ~x';

    public function validate($value, Constraint $constraint)
    {
        if (!preg_match(static::PATTERN, $value, $matches)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('%string%', $value)
                ->addViolation();
        }
    }
}
