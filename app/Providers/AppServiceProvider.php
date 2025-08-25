<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Session;
use App\Session\ClientSessionHandler;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        Paginator::useTailwind();

        Relation::morphMap([
            'training' => \App\Models\TrainingSession::class,
            'course' => \App\Models\Course::class,
            'subscription' => \App\Models\Subscription::class,
            'task' => \App\Models\Task::class,
        ]);
        
        $this->app->bind('session.handler', function ($app) {
            $connection = $app['db']->connection(config('session.connection'));
            $table = config('session.table');
            $minutes = config('session.lifetime');

            return new ClientSessionHandler($connection, $table, $minutes, $app['events']);
        });

        Blade::directive('secureAsset', function ($expression) {
            return "<?php echo env('APP_ENV') === 'local' ? asset($expression) : secure_asset($expression); ?>";
        });

        // forse HTTPS when load from oxide
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        // allow bcc when sending emails
        
    }
}
