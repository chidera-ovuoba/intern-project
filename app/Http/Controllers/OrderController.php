<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Products;
use Validator;

class OrderController extends Controller
{
  public function store(Request $request){

    //validating the request 
    \Log::info('Request Data:', $request->all());
    $validator = Validator::make($request->all(),[
        'email' => 'required|email',
        'items' => 'required|array',
        'items.*.product_id' => 'required|exists:products,id',
        'items.*.quantity' => 'required|integer|min:1',
    ]
    );
    if($validator->fails()){
        return response()->json(['error'=>$validator -> errors()], 400);
    }
   //create order
    $order = Order::create(['email'=> $request->email]);
    $totalAmount = 0;
    //looping through the request items array
    foreach($request->items as $item){
        //for each order item finding the corresponding product 
        $product = Products::find($item['product_id']);
        //Checking we have enough stock for the quantity ordered
        if($item['quantity'] > $product->stock){
            return response()->json(['error' => 'Insufficient stock for product ID '. $item['product_id']], 400);
        }
        $orderItem =OrderItem::create([
            'order_id'=>$order->id,
            'product_id'=>$item['product_id'],
            'quantity' =>$item['quantity'],
            'price' => $product->price
        ]);

        //updating the stock
        $product->stock -=$item['quantity'];
        $product->save();

        $totalAmount += $orderItem->quantity * $orderItem->price;
    }
    $order->update(['total'=>$totalAmount]);
    return response()->json([
        'order_id'=>$order->id,
        'total amount'=>$order->total,
        'message'=>'Order created successfully'
    ],201);
  }

}
