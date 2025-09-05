<?php

namespace App\Http\Middleware;

use App\AdminMenu;
use App\Utils\ModuleUtil;
use Closure;
use Menu;

class AdminSidebarMenu
{
    public function handle($request, Closure $next)
    {
        if ($request->ajax()) {
            return $next($request);
        }

        Menu::create('admin-sidebar-menu', function ($menu) {
            $items = AdminMenu::orderBy('order')->get();
            foreach ($items as $item) {
                if (empty($item->permission) || auth()->user()->can($item->permission)) {
                    $menu->url(
                        $item->url,
                        $item->label,
                        [
                            'icon' => $item->icon,
                            'active' => request()->is(ltrim(parse_url($item->url, PHP_URL_PATH), '/')),
                        ]
                    )->order($item->order);
                }
            }
        });

        $moduleUtil = new ModuleUtil();
        $moduleUtil->getModuleData('modifyAdminMenu');

        return $next($request);
    }
}
