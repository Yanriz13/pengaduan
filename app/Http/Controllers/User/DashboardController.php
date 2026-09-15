<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $stnkCount = $user->pengaduanStnks()->count();
        $kecelakaanCount = $user->pengaduanKecelakaans()->count();
        $stnkTerbaru = $user->pengaduanStnks()->latest()->take(5)->get();
        $kecelakaanTerbaru = $user->pengaduanKecelakaans()->latest()->take(5)->get();

        return view('user.dashboard', compact('stnkCount', 'kecelakaanCount', 'stnkTerbaru', 'kecelakaanTerbaru'));
    }
}
