<?php

use PHPUnit\Framework\TestCase;

class LocationContextTest extends TestCase
{
    /**
     * @dataProvider getCurrentCurrencySymbolProvider
     *
     * @param $locale
     * @param $currencySymbol
     * @param $hasHeader
     */
    public function testGetCurrentCurrencySymbol($locale, $currencySymbol, $hasHeader)
    {
        // HeaderBag
        $headerBagMock = $this->getMockBuilder(\Symfony\Component\HttpFoundation\HeaderBag::class)
                            ->setMethods(['has', 'get'])
                            ->getMock();

        $headerBagMock->expects($this->once())
                    ->method('has')
                    ->with('accept-language')
                    ->willReturn($hasHeader);

        if($hasHeader) {
            $headerBagMock->expects($this->once())
                            ->method('get')
                            ->with('accept-language')
                            ->willReturn($locale);
        } else {
            $headerBagMock->expects($this->never())
                            ->method('get');
        }

        // Request
        $requestMock = $this->getMockBuilder(\Symfony\Component\HttpFoundation\Request::class)
                            ->getMock();

        $requestMock->headers = $headerBagMock;

        // RequestStack
        $requestStackMock = $this->getMockBuilder(\Symfony\Component\HttpFoundation\RequestStack::class)
                                    ->setMethods(['getCurrentRequest'])
                                    ->getMock();

        $requestStackMock->expects($this->once())
                            ->method('getCurrentRequest')
                            ->willReturn($requestMock);

        // Actual test
        $locationContext = new \AppBundle\Location\LocationContext($requestStackMock, 'DEF');
        $this->assertEquals($locationContext->getCurrentCurrencySymbol(), $currencySymbol, "The received currency symbol does not match the expected one.");
    }

    /**
     * @return array
     */
    public function getCurrentCurrencySymbolProvider(): array
    {
        return [
            ['pl-PL,pl;q=0.9,bg-BG;q=0.8,bg;q=0.7,en-US;q=0.6,en;q=0.5', 'PLN', true],
            ['de-DE,pl;q=0.9,bg-BG;q=0.8,bg;q=0.7,en-US;q=0.6,en;q=0.5', 'EUR', true],
            ['en-US,pl;q=0.9,bg-BG;q=0.8,bg;q=0.7,en-US;q=0.6,en;q=0.5', 'USD', true],
            ['pl,de-DE;q=0.9,bg-BG;q=0.8,bg;q=0.7,en-US;q=0.6,en;q=0.5', 'EUR', true],
            ['pl-PL,pl;q=0.9,bg-BG;q=0.8,bg;q=0.7,en-US;q=0.6,en;q=0.5', 'DEF', false],
            ['pl,de,fr', 'DEF', true]
        ];
    }
}