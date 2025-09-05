<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $business_id = request()->session()->get('user.business_id');
        $roles = Role::where('business_id', $business_id)->get();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'array',
        ]);

        $business_id = $request->session()->get('user.business_id');

        $role = Role::create([
            'name' => $data['name'],
            'guard_name' => 'web',
            'business_id' => $business_id,
        ]);

        $role->syncPermissions($data['permissions'] ?? []);

        return redirect()->route('admin.roles.index');
    }

    public function edit($id)
    {
        $business_id = request()->session()->get('user.business_id');
        $role = Role::where('business_id', $business_id)->findOrFail($id);
        $permissions = Permission::all();

        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        $business_id = $request->session()->get('user.business_id');
        $role = Role::where('business_id', $business_id)->findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'array',
        ]);

        $role->update(['name' => $data['name']]);
        $role->syncPermissions($data['permissions'] ?? []);

        return redirect()->route('admin.roles.index');
    }

    public function destroy($id)
    {
        $business_id = request()->session()->get('user.business_id');
        $role = Role::where('business_id', $business_id)->findOrFail($id);
        $role->delete();

        return redirect()->route('admin.roles.index');
    }
}
