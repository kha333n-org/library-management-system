<?php

namespace App\Http\Controllers\Admin\Roles;

use App\DataTables\Admin\Roles\RolesDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Roles\RoleStoreRequest;
use App\Http\Requests\Admin\Roles\RoleUpdateRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Role::class, 'roles');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(RolesDataTable $dataTable)
    {
        return $dataTable->render('admin.roles.index');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoleStoreRequest $request
     * @return RedirectResponse
     */
    public function store(RoleStoreRequest $request)
    {
        $role = Role::create(
            [
                'name' => $request->get('name'),
                'guard_name' => 'sanctum',
            ]
        );

        $permissions = $request->input('permissions', []);
        $role->permissions()->sync($permissions);

        return redirect()->route('roles.show', $role->id)
            ->with('type', 'success')
            ->with('message', 'Role created successfully!');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $permissions = Permission::all();

        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Display the specified resource.
     *
     * @param Role $role
     * @return Application|Factory|View
     */
    public function show(Role $role)
    {
        return view('admin.roles.view', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Role $role
     * @return Application|Factory|View
     */
    public function edit(Role $role)
    {
        session()->put('url.intended', url()->previous());
        $permissions = Permission::all();
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RoleUpdateRequest $request
     * @param Role $role
     * @return RedirectResponse
     */
    public function update(RoleUpdateRequest $request, Role $role)
    {
        $role->name = $request->get('name');
        $role->save();

        $permissions = $request->input('permissions', []);
        $role->syncPermissions($permissions);

        return redirect()->intended()
            ->with('type', 'success')
            ->with('message', 'Role Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     * @return JsonResponse
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return response()->json(
            [
                'type' => 'success',
                'message' => 'Role deleted successfully!',
            ]
        );
    }
}
