<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all(); // Ähli rugsatlary çekýäris
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'label' => 'required',
            'permissions' => 'required|array'
        ]);

        // Roly döretmek
        $role = Role::create([
            'name' => strtolower($request->name),
            'label' => $request->label
        ]);

        // Rugsatlary baglanyşdyrmak
        $role->permissions()->sync($request->permissions);

        return redirect()->route('admin.roles.index')->with('success', 'Täze rol we rugsatlar tassyklanyldy!');
    }
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'permissions' => 'array'
        ]);

        $role->update(['label' => $request->label]);

        // Rol bilen rugsatlary Many-to-Many arkaly birikdirýär (köne rugsatlary öçürip, täzelerini goýýar)
        $role->permissions()->sync($request->permissions);

        return redirect()->route('admin.roles.index')->with('success', 'Rol üstünlikli täzelendi!');
    }
}
