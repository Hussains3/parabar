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
            $user->fill($request->safe()->only(['name', 'email']));
            $user->password = Hash::make($request->password);

            if ($request->agent_id) {
                $user->agent_id = $request->agent_id;
            }

            if ($request->hasFile('photo')) {
                $path = $request->file('photo')->store('users/photos', 'public');
                $user->photo = $path;
            }

            $user->save();
            $user->assignRole($request->role);

            DB::commit();
            return redirect()->route('users.index')
                ->with(['status' => 200, 'message' => 'User created successfully']);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with(['status' => 500, 'message' => 'Error creating user: ' . $e->getMessage()]);
        }
    }

    public function show($id): View
    {
        $user = User::with('agency')->findOrFail($id);
        $roles = Role::all();
        $agents = Agent::all();
        return view('admin.users.show', compact('user', 'roles', 'agents'));
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

    public function assignrole(Request $request)
    {
        $request->validate([
            'userid' => 'required|exists:users,id',
            'rolename' => 'required|exists:roles,name',
        ]);

        try {
            $user = User::findOrFail($request->userid);
            $user->assignRole($request->rolename);

            return response()->json([
                'success' => 'Role Assigned',
                'roles' => Role::all(),
                'userRoles' => $user->roles,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error assigning role: ' . $e->getMessage()], 500);
        }
    }

    public function unassignrole(Request $request)
    {
        $request->validate([
            'userid' => 'required|exists:users,id',
            'rolename' => 'required|exists:roles,name',
        ]);

        try {
            $user = User::findOrFail($request->userid);
            $user->removeRole($request->rolename);

            return response()->json([
                'success' => 'Role Unassigned',
                'roles' => Role::all(),
                'userRoles' => $user->roles,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error removing role: ' . $e->getMessage()], 500);
        }
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
            $user->fill($request->safe()->only(['name', 'email']));

            if ($request->hasFile('photo')) {
                if ($user->photo) {
                    Storage::disk('public')->delete($user->photo);
                }
                $path = $request->file('photo')->store('users/photos', 'public');
                $user->photo = $path;
            }

            $user->save();
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

    public function createAgentUser(Request $request)
    {

        $agents = Agent::all();
        $roles = Role::where('name', 'agent')->get();
        return view('admin.users.agentcreate', compact('roles', 'agents'));
    }

    public function storeAgentUser(Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8'],
                'agent_id' => ['required', 'exists:agents,id'],
            ]);

            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->agent_id = $request->agent_id;

            if ($request->hasFile('photo')) {
                $path = $request->file('photo')->store('users/photos', 'public');
                $user->photo = $path;
            }

            $user->save();
            $user->assignRole('agent');

            DB::commit();
            return redirect()->route('users.index')
                ->with(['status' => 200, 'message' => 'Agent user created successfully']);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with(['status' => 500, 'message' => 'Error creating agent user: ' . $e->getMessage()]);
        }
    }
}
