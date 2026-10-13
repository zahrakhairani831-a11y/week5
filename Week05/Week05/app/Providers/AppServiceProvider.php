<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // pakai tampilan pagination sendiri (resources/views/vendor/pagination)
        Paginator::defaultView('vendor.pagination.inventory');
    }
}
