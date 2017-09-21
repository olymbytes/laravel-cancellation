<?php 

namespace Olymbytes\Cancellation;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Blueprint;

class CancellationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/laravel-cancellation.php' => config_path('laravel-cancellation.php'),
        ], 'config');

        $this->mergeConfigFrom(__DIR__ . '/../config/laravel-cancellation.php', 'laravel-cancellation');
    }
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        Blueprint::macro('cancellable', function () {
            return $this->timestamp('cancelled_at')->nullable();
        });
    }
}
