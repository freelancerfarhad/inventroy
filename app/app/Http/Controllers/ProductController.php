<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\Product;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function productPage():View{
        return view('pages.dashboard.product-page');
    }

    function CreateProduct(Request $request)
    {
        $user_id=$request->header('id');

        // Prepare File Name & Path
        $img=$request->file('img_url');

        $t=time();
        $file_name=$img->getClientOriginalExtension();
        $img_name="{$user_id}-{$t}.{$file_name}";
        $img_url="uploads/products/{$img_name}";


        // Upload File
        $img->move(public_path('uploads/products/'),$img_name);


        // Save To Database
        Product::create([
            'name'=>$request->input('name'),
            'price'=>$request->input('price'),
            'unit'=>$request->input('unit'),
            'img_url'=>$img_url,
            'category_id'=>$request->input('category_id'),
            'user_id'=>$user_id
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Product Added Successful',
        ],200);
    }

    function ListProduct(Request $request)
    {
        $user_id=$request->header('id');
        return Product::with('category')->where('user_id',$user_id)->get();
    }

    function UpdateProduct(Request $request)
    {
        $user_id=$request->header('id');
        $product_id=$request->input('id');

        if ($request->hasFile('img_url')) {

            // Upload New File
            $img=$request->file('img_url');
            $t=time();
            $file_name=$img->getClientOriginalExtension();
            $img_name="{$user_id}-{$t}.{$file_name}";
            $img_url="uploads/products/{$img_name}";
            $img->move(public_path('uploads/products'),$img_name);

            // Delete Old File
            $filePath=$request->input('file_path');
            File::delete($filePath);

    
            // Update Product

            return Product::where('id',$product_id)->where('user_id',$user_id)->update([
                'name'=>$request->input('name'),
                'price'=>$request->input('price'),
                'unit'=>$request->input('unit'),
                'img_url'=>$img_url,
                'category_id'=>$request->input('category_id')
            ]);

        } else {
             Product::where('id',$product_id)->where('user_id',$user_id)->update([
                'name'=>$request->input('name'),
                'price'=>$request->input('price'),
                'unit'=>$request->input('unit'),
                'category_id'=>$request->input('category_id'),
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Product Updated Successful',
            ],200);
        }


    }
    function DeleteProduct(Request $request)
    {
        $user_id=$request->header('id');
        $product_id=$request->input('id');
        $filePath=$request->input('file_path');
        File::delete($filePath);
        return Product::where('id',$product_id)->where('user_id',$user_id)->delete();

    }

    function ProductByID(Request $request)
    {
        $user_id=$request->header('id');
        $product_id=$request->input('id');
        return Product::where('id',$product_id)->where('user_id',$user_id)->first();
    }

}
