<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Product;
use App\Models\User;
use Validator;
use Illuminate\Http\Request;
use App\Http\Resources\Product as ProductResource;

class HomeController extends BaseController
{
   public function home(){

    $products = Product::all();
    
        return $this->sendResponse(ProductResource::collection($products), 'Products retrieved successfully.');
   }

       public function search($keywords)
    {

        $results = Product::where('name', 'LIKE','%'.$keywords.'%')->latest()->take(10)->get();
       
         return $this->sendResponse(ProductResource::collection($results),'Products retrieved successfully.');
    }
}
