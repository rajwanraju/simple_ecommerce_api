<?php

namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Product;
use Validator;
use App\Http\Resources\Product as ProductResource;
use Image;
use Illuminate\Support\Facades\Input;
use File;
use Illuminate\Support\Str;


class ProductController extends BaseController
{
    public function index()
    {
        $products = Product::all();

        return $this->sendResponse(ProductResource::collection($products), 'Products retrieved successfully.');
    }


    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $product = new Product();
        $product->name = $input['name'];
        $product->slug = str_slug($input['name']);
        $product->detail = $input['detail'];
        $product->quantity = $input['quantity'];
        $product->price = $input['price'];
        $product->image = $input['image'];
        $product->save();

        return $this->sendResponse(new ProductResource($product), 'Product created successfully.');
    }

    public function show($id)
    {
        $product = Product::where('id',$id)->orwhere('slug',$id)->first();

        if (is_null($product)) {
            return $this->sendError('Product not found.');
        }

        return $this->sendResponse(new ProductResource($product), 'Product retrieved successfully.');
    }

    public function update(Request $request,$id)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $product = Product::find($id);
        $product->name = $input['name'];
        $product->slug = str_slug($input['name']);
        $product->detail = $input['detail'];
        $product->quantity = isset($input['quantity']) ? $input['quantity'] :$product->quantity ;
        $product->price = isset($input['price']) ? $input['price'] : $product->price;
        $product->image = isset($input['image']) ? $input['image'] : $product->image;
        $product->status = isset($input['status']) ? $input['status'] : $product->status;
        $product->save();

        return $this->sendResponse(new ProductResource($product), 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return $this->sendResponse([], 'Product deleted successfully.');
    }


    public function storeImage(Request $request)
    {

      $path = public_path('/storage/products/');

      if(!File::isDirectory($path)){
        File::makeDirectory(public_path('/storage/products'),777,true);
    }

    if( $request->file('image')) {



        $image = $request->file('image');
        $png_url = "product-".time().".png";
        
        
        $img = Image::make($image->path());
        $img->resize(800, 800)->save($path.'/'.$png_url);
        
    }
    else{

        $image = $request->input('image');
        $png_url = "product-".time().".png";
        $path = public_path('/storage/products/') . $png_url;

        Image::make(file_get_contents($image))->save($path);  

    }


    return response()->json([
        "success" => true,
        "message" => "File successfully uploaded",
        "data" => $png_url
    ]);


}

}
