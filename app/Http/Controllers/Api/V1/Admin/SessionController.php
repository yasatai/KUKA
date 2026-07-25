<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();
        $user->loadMissing('roles.permissions');

        return response()->json([
            'data' => [
                'id' => $user->getKey(),
                'name' => $user->name,
                'email' => $user->email,
                'roles' => $user->roles->pluck('code')->values(),
                'permissions' => $user->roles
                    ->flatMap(fn (Role $role) => $role->permissions->pluck('code'))
                    ->unique()
                    ->sort()
                    ->values(),
            ],
        ]);
    }
}
