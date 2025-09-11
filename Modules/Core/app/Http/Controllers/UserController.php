<?php

namespace Modules\Core\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function show(Request $request, string $id): Response
    {
        $tenantId = $request->attributes->get('tenant_id');
        $user = User::where('tenant_id', $tenantId)->findOrFail($id);

        return response($user);
    }
}
