<?php

namespace Stripe_Legacy;

class OrderReturnTest extends TestCase
{
    const TEST_RESOURCE_ID = 'orret_123';

    public function testIsListable()
    {
        $this->expectsRequest(
            'get',
            '/v1/order_returns'
        );
        $resources = OrderReturn::all();
        $this->assertTrue(is_array($resources->data));
        $this->assertSame("Stripe_Legacy\\OrderReturn", get_class($resources->data[0]));
    }

    public function testIsRetrievable()
    {
        $this->expectsRequest(
            'get',
            '/v1/order_returns/' . self::TEST_RESOURCE_ID
        );
        $resource = OrderReturn::retrieve(self::TEST_RESOURCE_ID);
        $this->assertSame("Stripe_Legacy\\OrderReturn", get_class($resource));
    }
}
