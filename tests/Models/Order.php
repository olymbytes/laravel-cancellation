<?php 

namespace Olymbytes\Cancellation\Test\Models;

use Illuminate\Database\Eloquent\Model;
use Olymbytes\Cancellation\Traits\Cancellable;

class Order extends Model
{
    use Cancellable;
}