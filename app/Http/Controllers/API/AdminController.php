<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\DeliveriedOrder;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Resources\UserResource;

class AdminController extends BaseController
{
    public function dashboard(){

        $data['users'] = User::where('is_admin',0)->get();
        $data['orderDeliveried'] = DeliveriedOrder::get();
        $data['totalUser'] = User::where('is_admin',0)->count();
        $data['totalProducts'] = Product::count();
        $data['totalOrders'] = Order::count();
        $data['totalDeliveriedOrders'] = DeliveriedOrder::count();

        return $this->sendResponse($data, 'Admin data presest');
    }

    public function deliveried_orders(){

        $deliveriedOrder = DeliveriedOrder::get();
        return $this->sendResponse($deliveriedOrder, 'Admin data presest');
    }

    public function deliveried_order($id){

        $deliveriedOrder = DeliveriedOrder::where('order_id',$id)->get();
        return $this->sendResponse($deliveriedOrder, 'Admin data presest');
    }
}
