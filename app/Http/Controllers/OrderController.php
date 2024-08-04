<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidateOrders;
use Illuminate\Http\Request;
// use Illuminate\Http\JsonResponse;


class OrderController extends Controller
{

    public function store(Request $request)
    {
        // return '123';

        // $validatedData = $request->validated();

        // Transform the price if the currency is USD
        // if ($validatedData['currency'] === 'USD') {
        //     $validatedData['price'] *= 31;
        //     $validatedData['currency'] = 'TWD';
        // }

        // echo 'Hi!!!!!!!!!!!!!!!!!!';
        // return [];


        // For now, just returning the validated data

        // return [
        // 'status' => 'success',
        // 'data' => $validatedData
        // ];


        return response()->json([
            'status' => 'success',
            // 'data' => $validatedData
        ], 200);
    }
}
