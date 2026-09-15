<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        \Carbon\Carbon::setLocale('id');

        \Illuminate\Support\Facades\View::composer('layouts.app', function ($view) {
            if (auth()->check() && auth()->user()->isAdmin()) {
                $countStnkBelum = \App\Models\PengaduanStnk::where('status', 'diajukan')->count();
                $countKecelakaanBelum = \App\Models\PengaduanKecelakaan::where('status', 'baru')->count();
                $totalNotifAdmin = $countStnkBelum + $countKecelakaanBelum;

                $stnkBelumDitangani = \App\Models\PengaduanStnk::with('user')
                    ->where('status', 'diajukan')
                    ->latest()
                    ->take(5)
                    ->get();

                $kecelakaanBelumDitangani = \App\Models\PengaduanKecelakaan::with('user')
                    ->where('status', 'baru')
                    ->latest()
                    ->take(5)
                    ->get();

                $view->with([
                    'countStnkBelum'           => $countStnkBelum,
                    'countKecelakaanBelum'     => $countKecelakaanBelum,
                    'totalNotifAdmin'          => $totalNotifAdmin,
                    'stnkBelumDitangani'       => $stnkBelumDitangani,
                    'kecelakaanBelumDitangani' => $kecelakaanBelumDitangani,
                ]);
            }
        });
    }
}
