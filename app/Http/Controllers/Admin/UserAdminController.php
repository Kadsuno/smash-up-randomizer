<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateUserRoleRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class UserAdminController extends Controller
{
    /**
     * List users with role management (admin area).
     */
    public function index(): View
    {
        $users = User::query()
            ->orderBy('role')
            ->orderBy('email')
            ->paginate(30);

        return view('backend.users.index', [
            'users' => $users,
        ]);
    }

    /**
     * Update a user's role.
     */
    public function updateRole(UpdateUserRoleRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        User::query()->whereKey((int) $validated['user_id'])->update([
            'role' => $validated['role'],
        ]);

        session()->flash('success', __('backend.flash_user_role_updated'));

        return redirect()->route('admin.users.index');
    }
}
