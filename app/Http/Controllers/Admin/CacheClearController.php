<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class CacheClearController extends Controller
{
    public function index(){
        return view('AdminDashboard.Cache.cache');
    }
    public function clearCache()
    {
        Artisan::call('cache:clear');
        return response()->json(['success' => 'Cache cleared successfully!']);
    }

    public function clearRouteCache()
    {
        Artisan::call('route:clear');
        return response()->json(['success' => 'Route cache cleared successfully!']);
    }

    public function clearConfigCache()
    {
        Artisan::call('config:clear');
        return response()->json(['success' => 'Config cache cleared successfully!']);
    }

    public function clearViewCache()
    {
        Artisan::call('view:clear');
        return response()->json(['success' => 'View cache cleared successfully!']);
    }

    public function clearCompiledCache()
    {
        Artisan::call('clear-compiled');
        return response()->json(['success' => 'Compiled File cache cleared successfully!']);
    }

    public function optimizeCache()
    {
        Artisan::call('optimize');
        return response()->json(['success' => 'Optimized Cache Cleared successfully!']);
    }
}
