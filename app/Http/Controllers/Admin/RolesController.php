<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RolesRequest;
use App\Http\Resources\RoleResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    private $routeResourceName = 'roles';

    public function index(Request $request){
        $roles = Role::query()
            ->select([
                'id',
                'name',
                'created_at',
            ])
            ->when($request->name, fn (Builder $builder, $name) => $builder->where('name', 'like', "%{$name}%"))
            ->latest('id')
            ->paginate(10);

        return Inertia::render('Role/Index', [
            'title' => 'Roles',
            'items' => RoleResource::collection($roles),
            'headers' => [
                [
                    'label' => 'Name',
                    'name' => 'name',
                ],
                [
                    'label' => 'Created At',
                    'name' => 'created_at',
                ],
                [
                    'label' => 'Actions',
                    'name' => 'actions',
                ],
            ],
            'filters' => (object) $request->all(),
            'routeResourceName' => $this->routeResourceName,
        ]);
    }

    public function create() {
        return Inertia::render('Role/Create', [
            'title' => 'Add Role',
            'edit' => false,
        ]);
    }

    public function store(RolesRequest $request) {
        Role::create($request->validated());
        return redirect()->route('admin.roles.index')->with('success', 'Role created successfully');
    }

    public function edit(Role $role) {
        return Inertia::render('Role/Create', [
            'title' => 'Edit Role',
            'edit' => true,
            'role' => new RoleResource($role),
        ]);
    }

    public function update(RolesRequest $request, Role $role) {
        $role->update($request->validated());

        return redirect()->route('admin.roles.index')->with('success', 'Role update successfully.');
    }

    public function destroy(Role $role) {
        $role->delete();

        return back()->with('success', 'Role delete successfully.');
    }
}
