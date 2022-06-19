<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\User as User;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $id = Auth::user()->id;
        if ($request->isMethod('post'))
        {
            return $this->update($request, $id);
        }
        $user = User::where('id', '=', $id)->first();
        if ($user)
        {
            return response()->view(
                'profile',
                [
                    'user'  => $user
                ]
            );
        }
        abort(404);
    }
}
