<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;

class CacheController extends Controller
{
    public function clearViewCache()
    {
        Artisan::call('view:clear');
        Artisan::call('cache:clear');
        Artisan::call('config:clear');

        return response()->json([
            'success' => true,
            'message' => 'Deleted: view cache, app cache, config cache'
        ]);
    }
}
