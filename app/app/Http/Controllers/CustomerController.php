<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Customer;
use Illuminate\View\View;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function CustomerPage():View{
        return view('pages.dashboard.customer-page');
    }
    public function CreateCustomer(Request $request) {
        $user_id=$request->header('id');
        try{
             Customer::create([
                'name'=>$request->input('name'),
                'email'=>$request->input('email'),
                'mobile'=>$request->input('mobile'),
                'user_id'=>$user_id,
            ]);
            return response()->json([
                'status'=>'success',
                'message'=>'Customer Create Successfuly !'
            ],200);
        }catch(Exception $e){
            return response()->json([
                'status'=>'fail',
                'message'=>'Customer Insert Fail Because ! from back-end'
            ],200);
        }
    }
    public function ListCustomer(Request $request) {
        $user_id=$request->header('id');
        return Customer::where('user_id','=',$user_id)->get();
    }
    function CustomerByID(Request $request){
        $customer_id=$request->input('id');
        $user_id=$request->header('id');
        return Customer::where('id',$customer_id)->where('user_id',$user_id)->first();
    }
    public function UpdateCustomer(Request $request) {

        try{
            $customer_id=$request->input('id');
            $user_id=$request->header('id');
            Customer::where('id','=',$customer_id)->where('user_id','=',$user_id)->update([
                'name'=>$request->input('name'),
                'email'=>$request->input('email'),
                'mobile'=>$request->input('mobile'),
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Customer Request Successful',
            ],200);

        }catch (Exception $exception){
            return response()->json([
                'status' => 'fail',
                'message' => 'Customer Went Wrong',
            ],200);
        }

    }
    public function DeleteCustomer(Request $request) {
             try{
                $customer_id=$request->input('id');
                $user_id=$request->header('id');
                 Customer::where('id',$customer_id)->where('user_id',$user_id)->delete();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Customer Deleted Successful',
                ],200);
        }catch(Exception $e){
            return response()->json([
                'status' => 'fail',
                'message' => 'Customer Not Deleted Successful',
            ],200);
        }

    }
}
