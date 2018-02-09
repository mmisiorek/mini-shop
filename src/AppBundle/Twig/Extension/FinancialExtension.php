<?php

namespace AppBundle\Twig\Extension;

use Twig\Extension\AbstractExtension;

class FinancialExtension extends AbstractExtension
{
    /**
     * @return \Twig_SimpleFilter[]
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('price', [$this, 'priceFilter'])
        ];
    }

    /**
     * @param $value
     * @param string $currency
     * @return string
     */
    public function priceFilter($value, string $currency): string
    {
        return sprintf("%.02f %s", $value/100, $currency);
    }
}