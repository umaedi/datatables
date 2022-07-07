<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $user = User::latest()->get();
            return DataTables::of($user)->make(true);
        }
        return view('user.index');
    }

    public function destroy($id)
    {
        $user = User::findOrfail($id);
        $user->destroy($id);
        if ($user) {
            return response()->json([
                'success'   => true,
                'message'   => 'User berhasil dihapus',
                'user'      => $user
            ], 200);
        } else {
            return response()->json([
                'success'   => false,
                'message'   => 'User tidak ditemukan',
                'user'      => null
            ], 401);
        }
    }
}
