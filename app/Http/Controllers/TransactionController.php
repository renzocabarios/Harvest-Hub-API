<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionLine;
use App\Models\Customer;
use App\Models\CartLine;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => Transaction::with(["transaction_lines.product", "customer.user"])->get(),
            'status' => 'success',
            'message' => 'Get transaction success',
        ]);
    }

    public function store(Request $request)
    {

        try {
            DB::beginTransaction();

            $data = Transaction::create([
                'customer_id' => $request->customer_id
            ]);

            foreach ($request->products as $product) {
                TransactionLine::create([
                    'product_id' => $product["product_id"],
                    'quantity' => $product["quantity"],
                    'cost' => $product["cost"],
                    'transaction_id' => $data->id,
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
            'message' => 'Create transaction success',
        ]);
    }


    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'customer' => 'required|string',
            'approved' => 'required|string',
            'confirmed' => 'required|string'
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
            $data = Transaction::find($id);

            if ($data == null) {
                return response()->json([
                    'data' => [],
                    'status' => 'failed',
                    'message' => 'Transaction not found',
                ]);
            }

            $data->customer = $request->get('customer');
            $data->approved = $request->get('approved');
            $data->confirmed = $request->get('confirmed');

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
            'message' => 'Update transaction success',
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'data' => [Transaction::with(["transaction_lines.product", "customer.user"])->find($id)],
            'status' => 'success',
            'message' => 'Get transaction success',
        ]);
    }

    public function destroy($id)
    {
        $data = Transaction::find($id);

        if ($data == null) {
            return response()->json([
                'data' => [],
                'status' => 'failed',
                'message' => 'Transaction not found',
            ]);
        }
        $data->delete();

        return response()->json([
            'data' => [],
            'status' => 'success',
            'message' => 'Delete transaction success',
        ]);
    }

    public function checkout(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|numeric'
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

            $customer = Customer::with(["user", "cart.cart_lines.product"])->find($request->customer_id);
            $cart_lines = $customer["cart"]["cart_lines"];
            $cart = $customer["cart"];

            $data = Transaction::create([
                'customer_id' => $request->customer_id
            ]);

            foreach ($cart_lines as $product) {
                TransactionLine::create([
                    'product_id' => $product["product_id"],
                    'quantity' => $product["quantity"],
                    'cost' => $product["product"]["price"],
                    'transaction_id' => $data->id,
                ]);
            }

            CartLine::where('cart_id', $cart["id"])->delete();

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
            'message' => 'Create transaction success',
        ]);
    }


}