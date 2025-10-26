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
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->staff_id_no = $request->staff_id_no;
            $user->post = $request->post;
            $user->work_site = $request->work_site;
            $user->address = $request->address;
            $user->whatsapp = $request->whatsapp;
            $user->password = Hash::make($request->password);
            $user->father_name = $request->father_name;
            $user->father_mobile = $request->father_mobile;
            $user->mother_name = $request->mother_name;
            $user->mother_mobile = $request->mother_mobile;
            $user->wife_name = $request->wife_name;
            $user->wife_mobile = $request->wife_mobile;
            $user->date_of_birth = $request->date_of_birth;
            $user->blood_group = $request->blood_group;
            $user->home_address = $request->home_address;
            $user->ref_name = $request->ref_name;

            if ($request->hasFile('photo')) {
                $image = $request->photo;
                $ext = $image->getClientOriginalExtension();
                $filename = uniqid() . '.' . $ext;
                $request->photo->move(public_path('staffimages'), $filename);
                $user->photo = 'staffimages/'.$filename;
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

            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->staff_id_no = $request->staff_id_no;
            $user->post = $request->post;
            $user->work_site = $request->work_site;
            $user->address = $request->address;
            $user->whatsapp = $request->whatsapp;
            $user->password = Hash::make($request->password);
            $user->father_name = $request->father_name;
            $user->father_mobile = $request->father_mobile;
            $user->mother_name = $request->mother_name;
            $user->mother_mobile = $request->mother_mobile;
            $user->wife_name = $request->wife_name;
            $user->wife_mobile = $request->wife_mobile;
            $user->date_of_birth = $request->date_of_birth;
            $user->blood_group = $request->blood_group;
            $user->home_address = $request->home_address;
            $user->ref_name = $request->ref_name;
            if ($request->hasFile('photo')) {
                $image = $request->photo;
                $ext = $image->getClientOriginalExtension();
                $filename = uniqid() . '.' . $ext;
                Storage::delete("staffimages/{$user->image}");
                $request->photo->move(public_path('staffimages'), $filename);
                $user->photo = 'staffimages/'.$filename;
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

            return redirect()->route('users.show', $user)
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

            // Delete old photo
            if ($user->photo) {
                unlink($user->photo);
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
