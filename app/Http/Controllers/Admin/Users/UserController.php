<?php

namespace App\Http\Controllers\Admin\Users;

use App\DataTables\Admin\Users\UsersListDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\UserUpdateRequest;
use App\Models\User;

class UserController extends Controller
{
    public function index(UsersListDataTable $dataTable)
    {
        return $dataTable->render('admin.users.index');
    }

    public function view(User $user)
    {
        return view('admin.users.view', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(User $user, UserUpdateRequest $request)
    {
        $user->name = $request->get('name');
        $user->address = $request->get('address');
        $user->phone_number = $request->get('phone_number');
        $user->is_active = $request->get('status');
        $user->save();

        return redirect()->route('users.view', $user->id)
            ->with('success')
            ->with('message', 'User updated successfully!');
    }
}
