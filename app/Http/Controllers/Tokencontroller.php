<?php

namespace App\Http\Controllers;

use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Tokencontroller extends Controller
{
    public function getToken()
    {
        $data = Token::all();
        if ($data) {
            return response([
                'message' => 'Successfully Fetched Data',
                'status' => 'success',
                'data' => $data
            ], 201);
        } else {
            return response([
                'message' => 'Something Went Wrong',
                'status' => 'failed',
            ], 500);
        }
    }

    public function addToken(Request $req)
    {

        $validator = Validator::make($req->all(), [
            'title' => 'required',
            'description' => 'required',
            'email' => 'required|email|unique:tokens'
        ]);


        if ($validator->fails()) {
            return response([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
                'status' => 'error'
            ], 422);
        }


        $data = [
            'title' => $req->input('title'),
            'description' => $req->input('description'),
            'email' => $req->input('email')
        ];

        $newData =   Token::create($data);

        if ($data) {

            return response([
                'message' => 'Successfully added',
                'status' => 'success',
                'data' => $newData
            ], 201);
        }
    }



    public function updateToken(Request $req, $id)
    {
        $token = Token::find($id);
    
        if (!$token) {
            return response([
                'message' => 'Token not found',
                'status' => 'unsuccessful',
            ], 404);
        }
    
        $validator = Validator::make($req->all(), [
            'email' => 'email|unique:tokens,email,' . $id,
        ]);
    
        if ($validator->fails()) {
            return response([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
                'status' => 'error',
            ], 422);
        }
    
        $fields = ['email', 'title', 'description'];
    
        foreach ($fields as $field) {
            if ($req->has($field)) {
                $token->$field = $req->input($field);
            }
        }
    
        $token->save();
    
        return response([
            'message' => 'Successfully Updated',
            'status' => 'success',
            'data' => $token,
        ], 200);
    }
    
    public function deleteToken($id)
{
    $data = Token::find($id);

    if (!$data) {
        return response([
            'message' => 'No Match Data Found',
            'status' => 'unsuccessful',
        ], 404);
    }

    $data->delete();

    return response([
        'message' => 'Data deleted successfully',
        'status' => 'success',
    ], 200);
}

    
}
