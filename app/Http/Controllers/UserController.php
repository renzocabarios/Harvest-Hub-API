<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\Farmer;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => User::with([])->get(),
            'status' => 'success',
            'message' => 'Get user success',
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
            'first_name' => 'required|string',
            'type' => 'required|string',
            'last_name' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'status' => 'failed',
                'message' => 'The form is not valid',
            ]);
        }

        try {
            DB::beginTransaction();


            $data = User::create([
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'type' => $request->type,
            ]);

            $data->createToken('MyApp')->accessToken;

            if ($request->type == "Admin") {
                Admin::create([
                    'user_id' => $data->id,
                ]);
            }


            if ($request->type == "Green Grocer") {
                Farmer::create([
                    'user_id' => $data->id,
                ]);
            }

            if ($request->type == "Customer") {
                $customer = Customer::create([
                    'user_id' => $data->id,
                ]);

                $customer = Cart::create([
                    'customer_id' => $customer->id,
                ]);
            }


            DB::commit();
        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'data' => [],
                'status' => 'failed',
                'message' => $e,
            ]);
        }

        return response()->json([
            'data' => [$data],
            'status' => 'success',
            'message' => 'Create user success',
        ]);
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'first_name' => 'required|string',
            'last_name' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'status' => 'failed',
                'message' => 'The form is not valid',
            ]);
        }

        try {
            DB::beginTransaction();
            $data = User::find($id);

            if ($data == null) {
                return response()->json([
                    'data' => [],
                    'status' => 'failed',
                    'message' => 'User not found',
                ]);
            }

            $data->email = $request->get('email');
            $data->first_name = $request->get('first_name');
            $data->last_name = $request->get('last_name');

            $data->save();
            DB::commit();
        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'data' => [],
                'status' => 'failed',
                'message' => $e,
            ]);
        }

        return response()->json([
            'data' => [$data],
            'status' => 'success',
            'message' => 'Update user success',
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'data' => [User::with([])->find($id)],
            'status' => 'success',
            'message' => 'Get user success',
        ]);
    }

    public function destroy($id)
    {
        $data = User::find($id);

        if ($data == null) {
            return response()->json([
                'data' => [],
                'status' => 'failed',
                'message' => 'User not found',
            ]);
        }
        $data->delete();

        return response()->json([
            'data' => [],
            'status' => 'success',
            'message' => 'Delete user success',
        ]);
    }
}