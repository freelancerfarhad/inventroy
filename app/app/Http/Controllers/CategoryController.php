<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function CategoryPage():View{
        return view('pages.dashboard.category-page');
    }
    public function CreateCategory(Request $request) {
        $user_id=$request->header('id');
        try{
            Category::create([
                'name'=>$request->input('name'),
                'user_id'=>$user_id,
            ]);
            return response()->json([
                'status'=>'success',
                'message'=>'Category Create Successfuly !'
            ],200);
        }catch(Exception $e){
            return response()->json([
                'status'=>'fail',
                'message'=>'Category Insert Fail Because ! from back-end'
            ],200);
        }
    }
    public function ListCategory(Request $request) {
        $user_id=$request->header('id');
        return Category::where('user_id','=',$user_id)->get();
    }
    function CategoryByID(Request $request){
        $category_id=$request->input('id');
        $user_id=$request->header('id');
        return Category::where('id',$category_id)->where('user_id',$user_id)->first();
    }
    public function UpdateCategory(Request $request) {

        try{
            $category_id=$request->input('id');
            $user_id=$request->header('id');
            Category::where('id','=',$category_id)->where('user_id','=',$user_id)->update([
                'name'=>$request->input('name'),
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Category Updated Successful',
            ],200);

        }catch (Exception $exception){
            return response()->json([
                'status' => 'fail',
                'message' => 'Category Went Wrong',
            ],200);
        }

    }
    public function DeleteCategory(Request $request) {
             try{
                $category_id=$request->input('id');
                $user_id=$request->header('id');
                Category::where('id',$category_id)->where('user_id',$user_id)->delete();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Category Deleted Successful',
                ],200);
        }catch(Exception $e){
            return response()->json([
                'status' => 'fail',
                'message' => 'Category Not Deleted Successful',
            ],200);
        }

    }
}
