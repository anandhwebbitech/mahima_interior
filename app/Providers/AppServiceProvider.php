<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Followup;
use App\Models\Menu;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


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
        View::composer('*', function ($view) {

            /* =======================
               🔔 Reminder Count
            ======================== */
            $today = Carbon::today()->toDateString();

            $reminderCount = Followup::where('status', 1)
                ->whereDate('followup_date', $today)
                ->whereHas('customer', function ($q) {
                    $q->where('cus_status', 1);
                })
                ->count();

            $view->with('reminderCount', $reminderCount);


            /* =======================
               📌 Role Based Menus
            ======================== */
            if (Auth::check()) {
                $role = Role::find(Auth::user()->role);
                
                $menuIds = json_decode($role->menus ?? '[]', true);

                $sidebarMenus = Menu::whereIn('id', $menuIds)
                    ->where('status', 1)
                    ->orderBy('id')
                    ->get();

                $view->with('sidebarMenus', $sidebarMenus);
            }
        });
    
    }
}
