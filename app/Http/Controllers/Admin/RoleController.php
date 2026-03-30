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
    private function currentLevel(Request $request): int
    {
        $user = $request->user();
        if (!$user) {
            return 0;
        }

        return (int) ($user->roles()->max('level') ?? 0);
    }

    private function isSelfRole(Request $request, Role $role): bool
    {
        $user = $request->user();
        if (!$user) {
            return false;
        }

        return $user->roles()->whereKey($role->getKey())->exists();
    }

    public function index(): View
    {
        $roles = Role::query()
            ->withCount(['users', 'permissions'])
            ->orderByDesc('level')
            ->orderByDesc('is_required')
            ->orderBy('slug')
            ->get();

        return view('admin.roles.index', [
            'roles' => $roles,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $currentLevel = $this->currentLevel($request);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:80'],
            'slug' => ['nullable', 'string', 'max:80', 'unique:roles,slug'],
            'level' => ['nullable', 'integer', 'min:1', 'max:' . max(1, $currentLevel - 1)],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        $slug = $data['slug'] ?: Str::slug($data['name']);
        if ($slug === '') {
            $slug = Str::random(8);
        }

        Role::query()->create([
            'name' => $data['name'],
            'slug' => $slug,
            'level' => isset($data['level']) ? (int) $data['level'] : max(1, $currentLevel - 1),
            'description' => $data['description'] ?? null,
            'is_required' => false,
            'is_system' => false,
        ]);

        return back();
    }

    public function edit(Request $request, Role $role): View
    {
        $currentLevel = $this->currentLevel($request);
        $selfRole = $this->isSelfRole($request, $role);

        $role->load('permissions');

        $permissions = Permission::query()
            ->orderBy('group')
            ->orderBy('key')
            ->get()
            ->groupBy(fn (Permission $p) => $p->group ?: 'general');

        return view('admin.roles.edit', [
            'role' => $role,
            'permissions' => $permissions,
            'currentLevel' => $currentLevel,
            'selfRole' => $selfRole,
        ]);
    }

    public function update(Request $request, Role $role): RedirectResponse
    {
        $currentLevel = $this->currentLevel($request);
        $selfRole = $this->isSelfRole($request, $role);

        if ($selfRole) {
            return back()->withErrors(['role' => __('You cannot modify permissions for a role assigned to your account.')]);
        }

        if ($role->level >= $currentLevel) {
            return back()->withErrors(['role' => __('You can only manage roles below your level.')]);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:80'],
            'slug' => ['required', 'string', 'max:80', 'unique:roles,slug,' . $role->id],
            'level' => ['nullable', 'integer', 'min:1', 'max:' . max(1, $currentLevel - 1)],
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
            'level' => $role->is_system ? $role->level : (isset($data['level']) ? (int) $data['level'] : $role->level),
            'description' => $data['description'] ?? null,
        ]);

        $role->permissions()->sync($data['permissions'] ?? []);

        return redirect()->route('admin.roles.edit', $role);
    }

    public function destroy(Request $request, Role $role): RedirectResponse
    {
        if ($this->isSelfRole($request, $role)) {
            return back()->withErrors(['role' => __('You cannot delete a role assigned to your account.')]);
        }

        abort_if($role->is_required || $role->is_system, 403);

        $role->delete();

        return redirect()->route('admin.roles.index');
    }
}
