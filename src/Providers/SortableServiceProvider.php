<?php

declare(strict_types=1);


namespace Plutuss\Providers;

use Illuminate\Support\ServiceProvider;

class SortableServiceProvider extends ServiceProvider
{

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/sortable.php' => config_path('sortable.php'),
        ]);


    }
}