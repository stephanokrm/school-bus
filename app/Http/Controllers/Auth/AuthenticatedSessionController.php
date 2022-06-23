<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 *
 */
class AuthenticatedSessionController extends Controller
{
    /**
     * @param  Request  $request
     * @return Response
     */
    public function destroy(Request $request): Response
    {
        $request->user()->token()->revoke();

        return response()->noContent();
    }
}
