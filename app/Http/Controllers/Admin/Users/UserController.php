<?php

namespace App\Http\Controllers\Admin\Users;

use App\DataTables\Admin\Users\UsersListDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\StoreUserRequest;
use App\Http\Requests\Admin\Users\UserUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
        session()->put('url.intended', url()->previous());
        return view('admin.users.edit', compact('user'));
    }

    public function update(User $user, UserUpdateRequest $request)
    {
        $user->name = $request->get('name');
        $user->address = $request->get('address');
        $user->phone_number = $request->get('phone_number');
        $user->is_active = $request->get('status');
        $user->save();

        return redirect()->intended()
            ->with('type', 'success')
            ->with('message', 'User updated successfully!');
    }

    public function destroy(User $user)
    {
        if ($user->canDelete()) {
            $user->delete();
            return response()->json(
                [
                    'type' => 'success',
                    'message' => 'User deleted successfully!',
                ]
            );
        } else {
            return response()->json(
                [
                    'type' => 'error',
                    'message' => 'Cannot delete user',
                ]
            );
        }

    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::query()->create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make(fake()->password),
            'phone_number' => $request->get('phone_number'),
            'address' => $request->get('address'),
            'is_active' => $request->get('status'),
        ]);

        return redirect()->route('users.view', $user->id)
            ->with('type', 'success')
            ->with('message', 'User created successfully! User must reset its password first to access account.');
    }
}
