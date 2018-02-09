<?php

namespace Tests\AppBundle\Financial;

use AppBundle\Financial\FinancialContext;
use PHPUnit\Framework\TestCase;

class FinancialContetTest extends TestCase
{
    /**
     * @dataProvider currencySymbolProvider
     *
     * @param $locale
     * @param $currencySymbol
     */
    public function testGetCurrencySymbol($locale, $currencySymbol)
    {
        $context = new FinancialContext($locale);
        $this->assertEquals($currencySymbol, $context->getCurrentCurrencySymbol());
    }

    public function currencySymbolProvider()
    {
        return [
            ['pl_PL', 'PLN'],
            ['de_DE', 'EUR'],
            ['en_US', 'USD'],
            ['en_GB', 'GBP'],
            ['pl', 'PLN'],
            ['de', 'EUR'],
            ['en', 'USD']
        ];
    }
}