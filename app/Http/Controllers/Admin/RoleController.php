<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

final class RoleController extends Controller
{
    public function index(): View
    {
        $roles = Role::query()
            ->withCount(['users', 'permissions'])
            ->orderByDesc('is_required')
            ->orderBy('name')
            ->get();

        return view('admin.roles.index', [
            'roles' => $roles,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:80'],
            'slug' => ['nullable', 'string', 'max:80', 'unique:roles,slug'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        $slug = $data['slug'] ?: Str::slug($data['name']);
        if ($slug === '') {
            $slug = Str::random(8);
        }

        Role::query()->create([
            'name' => $data['name'],
            'slug' => $slug,
            'description' => $data['description'] ?? null,
            'is_required' => false,
            'is_system' => false,
        ]);

        return back();
    }

    public function edit(Role $role): View
    {
        $role->load('permissions');

        $permissions = Permission::query()
            ->orderBy('group')
            ->orderBy('key')
            ->get()
            ->groupBy(fn (Permission $p) => $p->group ?: 'general');

        return view('admin.roles.edit', [
            'role' => $role,
            'permissions' => $permissions,
        ]);
    }

    public function update(Request $request, Role $role): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:80'],
            'slug' => ['required', 'string', 'max:80', 'unique:roles,slug,' . $role->id],
            'description' => ['nullable', 'string', 'max:500'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['integer', 'exists:permissions,id'],
        ]);

        if ($role->is_required) {
            $data['slug'] = $role->slug;
        }

        $role->update([
            'name' => $data['name'],
            'slug' => $data['slug'],
            'description' => $data['description'] ?? null,
        ]);

        $role->permissions()->sync($data['permissions'] ?? []);

        return redirect()->route('admin.roles.edit', $role);
    }

    public function destroy(Role $role): RedirectResponse
    {
        abort_if($role->is_required || $role->is_system, 403);

        $role->delete();

        return redirect()->route('admin.roles.index');
    }
}

