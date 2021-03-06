<?php

namespace Stripe_Legacy;

class ExchangeRateTest extends TestCase
{
    public function testIsListable()
    {
        $this->stubRequest(
            'get',
            '/v1/exchange_rates',
            array(),
            null,
            false,
            array(
                'object' => 'list',
                'data' => array(
                    array(
                        'id' => 'eur',
                        'object' => 'exchange_rate',
                        'rates' => array('usd' => 1.18221),
                    ),
                    array(
                        'id' => 'usd',
                        'object' => 'exchange_rate',
                        'rates' => array('eur' => 0.845876),
                    ),
                ),
            )
        );

        $listRates = ExchangeRate::all();
        $this->assertTrue(is_array($listRates->data));
        $this->assertEquals('exchange_rate', $listRates->data[0]->object);
    }

    public function testIsRetrievable()
    {
        $this->stubRequest(
            'get',
            '/v1/exchange_rates/usd',
            array(),
            null,
            false,
            array(
                'id' => 'usd',
                'object' => 'exchange_rate',
                'rates' => array('eur' => 0.845876),
            )
        );
        $rates = ExchangeRate::retrieve("usd");
        $this->assertEquals('exchange_rate', $rates->object);
    }
}
