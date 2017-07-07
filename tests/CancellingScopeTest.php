<?php 

namespace Olymbytes\Cancellation\Test;

use Olymbytes\Cancellation\Test\Models\Order;

class CancellingScopeTest extends TestCase
{
    /** @test */
    function it_excludes_cancelled_orders_by_default()
    {
        $this->assertCount(25, Order::all());
    }

    /** @test */
    function it_can_include_cancelled_orders()
    {
        $this->assertCount(50, Order::withCancelled()->get());
    }

    /** @test */
    function it_can_only_receive_cancelled_orders()
    {
        $this->assertCount(25, Order::onlyCancelled()->get());
    }

    /** @test */
    function it_can_exclude_cancelled_orders()
    {
        $this->assertCount(25, Order::withoutCancelled()->get());
    }
}