<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Product;
use Validator;
use App\Http\Resources\OrderResource;
use Auth;

class CustomerController extends BaseController
{
    public function myOrders(){

        $orders = Order::where('customer_id',Auth::user()->id)->with('orderHistory')->orderby('id','desc')->get();
        return $this->sendResponse(OrderResource::collection($orders), 'Customers Orders.');
    }
}
