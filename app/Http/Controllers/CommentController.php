<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => Comment::with(["transaction.customer.user"])->get(),
            'status' => 'success',
            'message' => 'Get comment success',
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'transaction_id' => 'required|numeric',
            'quality' => 'required|string',
            'accuracy' => 'required|string',
            'delivery' => 'required|string',
            'feedback' => 'required|string',
            'eco' => 'required|numeric',
            'rate' => 'required|numeric'
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

            $data = Comment::create([
                'transaction_id' => $request->transaction_id,
                'quality' => $request->quality,
                'accuracy' => $request->accuracy,
                'delivery' => $request->delivery,
                'feedback' => $request->feedback,
                'eco' => $request->eco,
                'rate' => $request->rate,
            ]);

            $data = Transaction::find($data->id);
            $data->confirmed = true;

            $data->save();
            DB::commit();
        } catch (\Exception $e) {

            DB::rollback();
            return response()->json([
                'data' => [$e],
                'status' => 'failed',
                'message' => 'Create comment failed',
            ]);
        }

        return response()->json([
            'data' => [$data],
            'status' => 'success',
            'message' => 'Create comment success',
        ]);
    }


    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'transaction_id' => $request->transaction_id,
            'customer_id' => $request->customer_id,
            'content' => $request->content,
            'rate' => $request->rate,
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
            $data = Comment::find($id);

            if ($data == null) {
                return response()->json([
                    'data' => [],
                    'status' => 'failed',
                    'message' => 'Product not found',
                ]);
            }

            $data->transaction_id = $request->get('transaction_id');
            $data->customer_id = $request->get('customer_id');
            $data->content = $request->get('content');
            $data->rate = $request->get('rate');

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
            'message' => 'Update comment success',
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'data' => [Comment::with([])->find($id)],
            'status' => 'success',
            'message' => 'Get comment success',
        ]);
    }

    public function destroy($id)
    {
        $data = Comment::find($id);

        if ($data == null) {
            return response()->json([
                'data' => [],
                'status' => 'failed',
                'message' => 'Comment not found',
            ]);
        }
        $data->delete();

        return response()->json([
            'data' => [],
            'status' => 'success',
            'message' => 'Delete comment success',
        ]);
    }
}