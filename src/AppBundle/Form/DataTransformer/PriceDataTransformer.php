<?php

namespace AppBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class PriceDataTransformer implements DataTransformerInterface
{
    public function transform($value)
    {
        if(!is_numeric($value)) {
            return null;
        }

        return $value/100;
    }

    public function reverseTransform($value)
    {
        if(!is_numeric($value)) {
            return null;
        }

        return floor($value*100);
    }

}