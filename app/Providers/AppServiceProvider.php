<?php

namespace App\Providers;

use App\Http\Responses\LogoutResponse;
use BezhanSalleh\FilamentShield\FilamentShield;
use Filament\Facades\Filament;
use Filament\Http\Responses\Auth\Contracts\LogoutResponse as LogoutResponseContract;
use Filament\Support\Facades\FilamentColor;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Spatie\Health\Checks\Checks\CacheCheck;
use Spatie\Health\Checks\Checks\DatabaseCheck;
use Spatie\Health\Checks\Checks\DatabaseConnectionCountCheck;
use Spatie\Health\Checks\Checks\DatabaseSizeCheck;
use Spatie\Health\Checks\Checks\DatabaseTableSizeCheck;
use Spatie\Health\Checks\Checks\DebugModeCheck;
use Spatie\Health\Checks\Checks\EnvironmentCheck;
use Spatie\Health\Checks\Checks\OptimizedAppCheck;
use Spatie\Health\Checks\Checks\UsedDiskSpaceCheck;
use Spatie\Health\Facades\Health;
use Spatie\SecurityAdvisoriesHealthCheck\SecurityAdvisoriesCheck;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(LogoutResponseContract::class, LogoutResponse::class);
        FilamentView::registerRenderHook(
            PanelsRenderHook::BODY_END,
            fn (): View => view('components.footer.index'),
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();

        if (app()->isProduction()) {
            URL::forceScheme('https');
        }

        if (! Filament::isServing()) {
            if (Filament::getCurrentPanel() !== null) {
                FilamentColor::register(Filament::getCurrentPanel()->getColors());
            }
        }

        FilamentShield::prohibitDestructiveCommands(app()->isProduction());

        Health::checks([
            CacheCheck::new(),
            DatabaseCheck::new(),
            DatabaseConnectionCountCheck::new(),
            DatabaseSizeCheck::new(),
            DatabaseTableSizeCheck::new(),
            OptimizedAppCheck::new(),
            DebugModeCheck::new(),
            EnvironmentCheck::new(),
            UsedDiskSpaceCheck::new(),
            SecurityAdvisoriesCheck::new(),
        ]);
    }
}
