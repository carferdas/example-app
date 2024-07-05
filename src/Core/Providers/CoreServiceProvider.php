<?php

namespace App\Core\Providers;

use App\Core\Database\Seed\DatabaseSeeder;

class CoreServiceProvider extends BaseServiceProvider
{
    public function boot(): void
    {
        $this->app->bind('DatabaseSeeder', function ($app) {
            return new DatabaseSeeder;
        });

        parent::boot();
    }
}
