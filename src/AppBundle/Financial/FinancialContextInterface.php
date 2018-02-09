<?php

namespace AppBundle\Financial;

interface FinancialContextInterface
{
    /**
     * @return string
     */
    public function getCurrentCurrencySymbol(): string;
}