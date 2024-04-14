<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\ProductCategories;
use Session;
use Auth;
use DB;

class AppViewData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $defaultShareData = [];
        
        $menuData = ProductCategories::with(['subcategories' => function ($subcatQuery) {
                $subcatQuery->where('status', 1);
            }])
            ->where('status', 1)
            ->where('menu_visibility', 1)
            ->orderBy('display_order', 'asc')
            ->get();
        
        $defaultShareData['menu_data'] = $menuData;
        View::share('defaultShareData', $defaultShareData);
        return $next($request);
    }
}
