<?php 

namespace Olymbytes\Cancellation\Traits;

use Olymbytes\Cancellation\Scopes\CancellingScope;

trait Cancellable
{
    /**
     * Boot the cancelable trait for a model.
     *
     * @return void
     */
    public static function bootCancellable()
    {
        static::addGlobalScope(new CancellingScope);
    }

    /**
     * Perform the actual cancel query on this model instance.
     *
     * @return void
     */
    public function cancel()
    {
        if ($this->fireModelEvent('cancelling') === false) {
            return false;
        }

        $time = $this->freshTimestamp();

        $this->{$this->getCancelledAtColumn()} = $time;
        $this->{$this->getUpdatedAtColumn()} = $time;

        $result = $this->save();

        $this->fireModelEvent('cancelled', false);

        return $result;
    }

    /**
     * Keep a cancelled model instance.
     *
     * @return bool|null
     */
    public function keep()
    {
        // If the restoring event does not return false, we will proceed with this
        // restore operation. Otherwise, we bail out so the developer will stop
        // the restore totally. We will clear the deleted timestamp and save.
        if ($this->fireModelEvent('keeping') === false) {
            return false;
        }

        $this->{$this->getCancelledAtColumn()} = null;

        $result = $this->save();

        $this->fireModelEvent('kept', false);

        return $result;
    }

    /**
     * Determine if the model instance has been cancelled.
     *
     * @return bool
     */
    public function cancelled()
    {
        return ! is_null($this->{$this->getCancelledAtColumn()});
    }

    /**
     * Register a restoring model event with the dispatcher.
     *
     * @param  \Closure|string  $callback
     * @return void
     */
    public static function keeping($callback)
    {
        static::registerModelEvent('keeping', $callback);
    }

    /**
     * Register a restored model event with the dispatcher.
     *
     * @param  \Closure|string  $callback
     * @return void
     */
    public static function kept($callback)
    {
        static::registerModelEvent('kept', $callback);
    }

    /**
     * Get the name of the "cancelled at" column.
     *
     * @return string
     */
    public function getCancelledAtColumn()
    {
        return defined('static::CANCELLED_AT') ? static::CANCELLED_AT : 'cancelled_at';
    }

    /**
     * Get the fully qualified "cancelled at" column.
     *
     * @return string
     */
    public function getQualifiedCancelledAtColumn()
    {
        return $this->getTable().'.'.$this->getCancelledAtColumn();
    }
}