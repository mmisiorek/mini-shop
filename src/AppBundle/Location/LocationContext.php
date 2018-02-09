<?php

namespace AppBundle\Location;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Intl\NumberFormatter\NumberFormatter;

class LocationContext implements LocationContextInterface
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var string
     */
    private $defaultCurrency;

    /**
     * LocationContext constructor.
     * @param RequestStack $requestStack
     * @param string $defaultCurrency
     */
    public function __construct(RequestStack $requestStack, string $defaultCurrency)
    {
        $this->requestStack = $requestStack;
        $this->defaultCurrency = $defaultCurrency;
    }

    /**
     * @return string
     */
    public function getCurrentCurrencySymbol(): string
    {
        $detectedLocale = $this->detectLocale();
        if($detectedLocale === null) {
            return $this->defaultCurrency;
        }

        $formatter = new \NumberFormatter($detectedLocale, NumberFormatter::CURRENCY);
        return $formatter->getSymbol(NumberFormatter::INTL_CURRENCY_SYMBOL);
    }

    /**
     * @return string|null
     */
    protected function detectLocale()
    {
        $request = $this->requestStack->getCurrentRequest();
        if(!$request->headers->has('accept-language')) {
            return null;
        }

        // take the header and remove the quantity attributes from the string
        $acceptedLanguages = preg_replace('/;q=[0-9]\.[0-9]+/', '', $request->headers->get('accept-language'));
        $languages = explode(',', $acceptedLanguages);

        foreach($languages as $language) {
            if(preg_match('/^[a-zA-Z]{2}-[a-zA-Z]{2}/', $language)) {
                return str_replace("-", '_', $language);
            }
        }

        return null;
    }
}