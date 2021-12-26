<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Product;
use App\Models\OrderHistory;
use Validator;
use App\Http\Resources\OrderResource;
use Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderPlaceMail;

class OrderController extends BaseController
{
    
    public function index()
    {
        $orders = Order::with('orderHistory')->get();
        return $this->sendResponse(OrderResource::collection($orders), 'All Orders.');
    }


    public function store(Request $request)
    {

        
       $input = $request->all();


       
       $validator = Validator::make($input, [
        'name' => 'required',
        'email' => 'required|email',
        'phone' => 'required',
        'address' => 'required',
        'products' => 'required',
        'subTotal' => 'required',
    ]);

       if($validator->fails()){
        return $this->sendError('Validation Error.', $validator->errors());       
    }
    
    $order = new Order();
    $order->order_id = 'ES-'.abs( crc32( uniqid() ) );
    $order->name = $input['name'];
    $order->email = $input['email'];
    $order->products = json_encode($input['products']);
    $order->phone_number = $input['phone'];
    $order->sub_total = $input['subTotal'];
    $order->grand_total = $input['subTotal'];
    $order->customer_id = Auth::user()->id;
    $order->shipping_address = $input['address'];
    $order->save();

    

    $admins = User::where('is_admin',1)->pluck('email');
    Mail::to($order->email)
    ->cc($admins)
    ->send(new OrderPlaceMail($order));

    
    return $this->sendResponse($order, 'Order Placed Successfully.');
}


public function show($id)
{
  $order = Order::with('orderHistory')->where('order_id',$id)->first();
return $this->sendResponse(new OrderResource($order), 'Order retrieved successfully.');
}

public function updateStatus($id,$status)
{
    $order = Order::where('order_id',$id)->first();
    $order->status = $status;
    $order->save();

// update order history
    $orderHistory = new OrderHistory();
    $orderHistory->order_id = $order->id;
    $orderHistory->edit_by = Auth::user()->name;
    $orderHistory->edit_at = 'status';
    $orderHistory->edit_value = $status;
    $orderHistory->save();


// product quantity decrise on deliveried status
    if($order->status == "Deliveried"){

        $products = json_decode($order->products);
        foreach($products as $product){

            $updateProduct = Product::find($product->id); 
            $updateProduct->quantity = $updateProduct->quantity - $product->quantity; 
            $updateProduct->save(); 
        }
    }
    return $this->sendResponse(new OrderResource($order), 'Order Status Changed Successfully.');
}


public function update(Request $request, $id)
{
    $mainOrder = Order::where('order_id',$id)->first();
   $order = Order::where('order_id',$id)->first();
   $order->name = $request->name;
   $order->phone_number = $request->phone;
   $order->shipping_address = $request->address;
   $order->save();

if($request->name != $mainOrder->name){
    $orderHistory = new OrderHistory();
    $orderHistory->order_id = $order->id;
    $orderHistory->edit_by = Auth::user()->name;
    $orderHistory->edit_at = 'phone_number';
    $orderHistory->edit_value = $request->phone;
    $orderHistory->save();
}
if($request->phone != $mainOrder->phone_number){
    $orderHistory = new OrderHistory();
    $orderHistory->order_id = $order->id;
    $orderHistory->edit_by = Auth::user()->name;
    $orderHistory->edit_at = 'phone_number';
    $orderHistory->edit_value = $request->phone;
    $orderHistory->save();
}

if($request->address != $mainOrder->shipping_address){
    $orderHistory = new OrderHistory();
    $orderHistory->order_id = $order->id;
    $orderHistory->edit_by = Auth::user()->name;
    $orderHistory->edit_at = 'shipping_address';
    $orderHistory->edit_value = $request->address;
    $orderHistory->save();
}

   return $this->sendResponse(new OrderResource($order), 'Order Update Successfully.');
}

public function destroy($id)
{
        //
}
}
