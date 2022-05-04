<?php

namespace Stripe_Legacy;

class BalanceTest extends TestCase
{
    public function testIsRetrievable()
    {
        $this->expectsRequest(
            'get',
            '/v1/balance'
        );
        $resource = Balance::retrieve();
        $this->assertSame("Stripe_Legacy\\Balance", get_class($resource));
    }
}
