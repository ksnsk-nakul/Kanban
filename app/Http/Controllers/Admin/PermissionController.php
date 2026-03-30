<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class PermissionController extends Controller
{
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));

        $permissions = Permission::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($q2) use ($q) {
                    $q2->where('key', 'like', "%{$q}%")
                        ->orWhere('name', 'like', "%{$q}%")
                        ->orWhere('group', 'like', "%{$q}%");
                });
            })
            ->orderBy('group')
            ->orderBy('key')
            ->paginate(40)
            ->withQueryString();

        return view('admin.permissions.index', [
            'permissions' => $permissions,
            'q' => $q,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'key' => ['required', 'string', 'max:120', 'unique:permissions,key'],
            'name' => ['required', 'string', 'max:120'],
            'group' => ['nullable', 'string', 'max:80'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        Permission::query()->create([
            'key' => $data['key'],
            'name' => $data['name'],
            'group' => $data['group'] ?: null,
            'description' => $data['description'] ?: null,
            'is_system' => false,
        ]);

        return back();
    }
}

