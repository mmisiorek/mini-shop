<?php

namespace AppBundle\Financial;

use Symfony\Component\Intl\NumberFormatter\NumberFormatter;

class FinancialContext implements FinancialContextInterface
{
    /**
     * @var string
     */
    private $locale;

    public function __construct(string $locale)
    {
        $this->locale = $locale;
    }

    /**
     * @return string
     */
    public function getCurrentCurrencySymbol(): string
    {
        $formatter = new \NumberFormatter($this->createLocaleForCurrency(), NumberFormatter::CURRENCY);
        return $formatter->getSymbol(NumberFormatter::INTL_CURRENCY_SYMBOL);
    }

    /**
     * @return string
     */
    private function createLocaleForCurrency(): string
    {
        if(preg_match('/^[a-zA-Z]{2}_[a-zA-Z]{2}$/', $this->locale)) {
            return $this->locale;
        } else if($this->locale === 'en') {
            return 'en_US';
        } else {
            return sprintf("%s_%s", $this->locale, strtoupper($this->locale));
        }
    }

}