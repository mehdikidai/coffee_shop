<?php

namespace App\Http\Controllers\web;

use App\Models\User;
use App\Enum\UserRole;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\TenantService;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;

class UsersController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index(Request $request): View
    {

        $search = trim((string) $request->input('search'));

        $usersQuery = User::withCount('orders')->latest();

        if ($search === "blocked") {
            $usersQuery->where('is_blocked', 1);
        } elseif ($search) {
            $usersQuery->where(function ($query) use ($search) {
                $query->where('email', 'like', "%$search%")
                    ->orWhere('name', 'like', "%$search%")
                    ->orWhere('role', 'like', "%$search%")
                    ->orWhere('id', 'like', $search);
            });
        }


        $pagination_limit = pagination_limit();

        $users = $usersQuery->paginate($pagination_limit)->appends($request->only(['search']));

        $key_login = TenantService::$tenantToken;

        return view('users', compact('users', 'key_login'));
    }


    public function edit(Request $request): View
    {
        $id = $request->id;
        $user = User::findOrFail($id);
        $roles = UserRole::values();
        return view('userEdit', compact('user', 'roles'));
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        if (!Gate::allows('delete-user', $user)) {
            return redirect()->back()->withErrors('You do not have permission to delete this user.');
        }

        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully.');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8'
        ]);

        Gate::authorize('create-user');

        $validated['table_key'] = $this->generateUniqueTableKey();
        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = UserRole::USER->value;

        User::create($validated);
        return redirect()->back()->with('success', 'User added successfully.');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {

        $rolesArray = UserRole::values();

        $validated = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($id),],
            'password' => ['nullable', 'min:8'],
            'role' => ['required', Rule::in($rolesArray)],
            'table_number' => ['required', 'integer']
        ]);

        $user = User::findOrFail($id);

        Gate::authorize('update-user', $user);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);
        return redirect()->back()->with('success', 'User updated successfully.');
    }


    public function show(){
        return abort(404);
    }

    public function toggleBlocked($id)
    {
        $user = User::findOrFail($id);
        $user->is_blocked = !$user->is_blocked;
        $user->save();
        //$status = $user->is_blocked ? 'blocked' : 'unblocked';
        return redirect()->back();
    }

    private function generateUniqueTableKey(): string
    {
        do {
            $key = Str::random(64);
        } while (User::where('table_key', $key)->exists());

        return $key;
    }
}
