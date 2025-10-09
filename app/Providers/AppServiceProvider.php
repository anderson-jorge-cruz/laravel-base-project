<?php

declare(strict_types = 1);

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Opcodes\LogViewer\Facades\LogViewer;

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
        $this->configModels();
        $this->configCommands();
        $this->configUrls();
        $this->configDate();
        $this->setupLogViewer();
    }

    private function setupLogViewer(): void
    {
        LogViewer::auth(function ($request) {
            return ! app()->isProduction();
        });
    }

    private function configModels(): void
    {
        Model::unguard();
        Model::shouldBeStrict();
    }

    private function configCommands(): void
    {
        DB::prohibitDestructiveCommands(
            app()->isProduction()
        );
    }

    private function configUrls(): void
    {
        URL::forceHttps();
    }

    private function configDate(): void
    {
        Date::use(CarbonImmutable::class);
    }
}
