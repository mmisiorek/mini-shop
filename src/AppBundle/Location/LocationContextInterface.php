<?php

namespace AppBundle\Location;

interface LocationContextInterface
{
    /**
     * @return string
     */
    public function getCurrentCurrencySymbol(): string;
}