<?php 

namespace Olymbytes\Cancellation\Test\Traits;

use Olymbytes\Cancellation\Test\Models\Order;

trait FindsOrders
{
    public function getCancelledOrder()
    {
        return Order::onlyCancelled()->get()->random();
    }

    public function getRegularOrder()
    {
        return Order::withoutCancelled()->get()->random();
    }
}
