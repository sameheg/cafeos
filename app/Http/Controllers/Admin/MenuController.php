<?php

namespace App\Http\Controllers\Admin;

use App\AdminMenu;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = AdminMenu::orderBy('order')->get();
        return view('admin.menus.index', compact('menus'));
    }

    public function create()
    {
        return view('admin.menus.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'label' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'permission' => 'nullable|string|max:255',
            'order' => 'required|integer',
        ]);

        AdminMenu::create($data);

        return redirect()->route('admin.menus.index');
    }

    public function edit(AdminMenu $menu)
    {
        return view('admin.menus.edit', compact('menu'));
    }

    public function update(Request $request, AdminMenu $menu)
    {
        $data = $request->validate([
            'label' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'permission' => 'nullable|string|max:255',
            'order' => 'required|integer',
        ]);

        $menu->update($data);

        return redirect()->route('admin.menus.index');
    }

    public function destroy(AdminMenu $menu)
    {
        $menu->delete();

        return redirect()->route('admin.menus.index');
    }
}

