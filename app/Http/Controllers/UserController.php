<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User as User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function detail(Request $request, $id)
    {
        if ($request->isMethod('post'))
        {
            return $this->update($request, $id);
        }

        $user = User::where('id', '=', $id)->first();
       
        if ($user)
        {
            return response()->view(
                'user_detail',
                [
                    'user'  => $user
                ]
            );
        }
        abort(404);
    }

    public function add(Request $request)
    {
        $data = request()->validate([
            'name' => 'required|min:3',
            'email' => 'required|min:2',
            'phone_no' => 'required|min:2',
            'password' => 'required',
        ]);

        $add = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_no' => $request->phone_no,
            'password' => Hash::make($request->password)
        ]);

        if($add){
            return response()->json(
                [
                    'success'   => true,
                    'msg'       => 'Add Successful'
                ]
            );
        }else{
            return response()->json(
                [
                    'success'   => false,
                    'msg'       => 'Add failed'
                ]
            );
        }
    }

    private function update(Request $request, $id)
    {
        if (
            ($request->email === '') 
        )
        {
            return response()->json(
                [
                    'success'   => false,
                    'msg'       => 'Not enough information'
                ]
            );
        }

        $data = array(
                        'name'      =>  $request->name,
                        'email'     =>  $request->email,
                        'phone_no'  =>  $request->phone_no,
                        'password'  =>  Hash::make($request->password)
                    );

        if($data){
            DB::table('users')->where('id', $id)->update($data);
            return response()->json(
                [
                    'success'   => true,
                    'msg'       => 'Update Successful'
                ]
            );
        }else{
            return response()->json(
                [
                    'success'   => false,
                    'msg'       => 'Update failed'
                ]
            );
        }
    }

    public function delete($id)
    {
        if($id){
            $delete = User::where('id', $id)->delete();
            return response()->json(
                [
                    'success'   => true,
                    'msg'       => 'Delete Successful'
                ]
            );
        }else{
            return response()->json(
                [
                    'success'   => false,
                    'msg'       => 'Delete failed'
                ]
            );
        }
    }

}
