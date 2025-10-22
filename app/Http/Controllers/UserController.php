<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Agent;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:user-list', ['only' => ['index']]),
            new Middleware('permission:user-create', ['only' => ['create', 'store', 'createAgentUser', 'storeAgentUser']]),
            new Middleware('permission:user-edit', ['only' => ['edit', 'update']]),
            new Middleware('permission:user-delete', ['only' => ['destroy']]),
        ];
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::with('roles')->get();
            return Datatables::of($users)->make(true);
        }
        return view('admin.users.index');
    }

    public function create(): View
    {
        $roles = Role::all();
        return view('admin.users.create', ['roles' => $roles]);
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $user = new User;

            // Basic Information
            $user->fill($request->safe()->only([
                'name',
                'email',
                'phone',
                'staff_id_no',
                'post',
                'work_site',
                'address',
                'whatsapp'
            ]));
            $user->password = Hash::make($request->password);

            // Personal Information
            $user->fill($request->safe()->only([
                'father_name',
                'father_mobile',
                'mother_name',
                'mother_mobile',
                'wife_name',
                'wife_mobile',
                'date_of_birth',
                'blood_group',
                'home_address',
                'ref_name'
            ]));

            if ($request->agent_id) {
                $user->agent_id = $request->agent_id;
            }

            // Handle Photo Upload
            if ($request->hasFile('photo')) {
                $path = $request->file('photo')->store('users/photos', 'public');
                $user->photo = $path;
            }

            $user->save();

            // Assign Role
            if ($request->role) {
                $user->assignRole($request->role);
            }

            DB::commit();
            return redirect()->route('users.index')
                ->with(['status' => 200, 'message' => 'User created successfully']);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with(['status' => 500, 'message' => 'Error creating user: ' . $e->getMessage()]);
        }
    }

    public function show(User $user): View
    {
        $roles = Role::all();
        return view('admin.users.show', compact('user','roles'));
    }

    public function showUserRoles($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        $userRoles = $user->roles;

        return response()->json([
            'roles' => $roles,
            'userRoles' => $userRoles,
        ]);
    }



    public function edit($id): View
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        $userRole = $user->roles->pluck('name', 'name')->all();
        return view('admin.users.edit', compact('user', 'roles', 'userRole'));
    }

    public function update(UpdateUserRequest $request, $id): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $user = User::findOrFail($id);

            // Basic Information
            $user->fill($request->safe()->only([
                'name',
                'email',
                'phone',
                'staff_id_no',
                'post',
                'work_site',
                'address',
                'whatsapp'
            ]));

            // Personal Information
            $user->fill($request->safe()->only([
                'father_name',
                'father_mobile',
                'mother_name',
                'mother_mobile',
                'wife_name',
                'wife_mobile',
                'date_of_birth',
                'blood_group',
                'home_address',
                'ref_name'
            ]));

            // Handle Photo Upload
            if ($request->hasFile('photo')) {
                if ($user->photo) {
                    Storage::disk('public')->delete($user->photo);
                }
                $path = $request->file('photo')->store('users/photos', 'public');
                $user->photo = $path;
            }

            // Handle Password Update
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            // Update Role if provided
            if ($request->role) {
                $user->syncRoles([$request->role]);
            }

            DB::commit();

            return redirect()->route('users.index')
                ->with(['status' => 200, 'message' => 'User updated successfully']);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with(['status' => 500, 'message' => 'Error updating user: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $user = User::findOrFail($id);

            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }

            $user->delete();
            DB::commit();

            return response()->json(['success' => 'User deleted successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error deleting user: ' . $e->getMessage()], 500);
        }
    }




}
