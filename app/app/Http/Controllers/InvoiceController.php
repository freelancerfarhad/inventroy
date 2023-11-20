<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Invoice;
use App\Models\Customer;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\InvoiceProduct;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function InvoicePage(): View{
        return view('pages.dashboard.invoice-page');
    }
   
    public function SalePage(): View{
        return view('pages.dashboard.sale-page');
    }
    // create invoice
    public function invoiceCreate(Request $request){

        DB::beginTransaction();
        try{
            $user_id=$request->header('id');
            $product_total=$request->input('total');
            $product_discount=$request->input('discount');
            $product_vat=$request->input('vat');
            $product_payable=$request->input('payable');
            $customer_id=$request->input('customer_id');
    
            $invoice =  Invoice::create([
                'total'=>$product_total,
                'user_id'=>$user_id,
                'discount'=>$product_discount,
                'vat'=>$product_vat,
                'customer_id'=>$customer_id,
                'payable'=>$product_payable
            ]);
    
            $invoiceID = $invoice->id;
            $products= $request->input('products');
    
            foreach ($products as $EachProduct) {
                InvoiceProduct::create([
                    'invoice_id' => $invoiceID,
                    'user_id' => $user_id,
                    'product_id' => $EachProduct['product_id'],
                    'qty' => $EachProduct['qty'],
                    'sale_price' => $EachProduct['sale_price'],
                ]);
            }
            DB::commit();
            return response()->json([
                'status'=>'success',
                'message'=>'Invoice Create Successfuly !'
            ],200);
        }catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'status'=>'fail',
                'message'=>'Invoice Fail Because ! from back-end'
            ],200);
        }

    }

    //list invoice
    public function ListInvoice(Request $request){
        $user_id=$request->header('id');
        return Invoice::with('customer','invoice')->where('user_id','=',$user_id)->get();

    }
    public function InvoiceDetails(Request $request){
        $user_id=$request->header('id');
        $customerDetails = Customer::where('user_id',$user_id)->where('id',$request->input('cus_id'))->first();
        $invoiceTotal = Invoice::where('user_id',$user_id)->where('id',$request->input('inv_id'))->first();
        // $invoiceProduct = InvoiceProduct::where('invoice_id',$request->input('inv_id'))->where('user_id',$user_id)->get();
        $invoiceProduct=InvoiceProduct::where('invoice_id',$request->input('inv_id'))
            ->where('user_id',$user_id)->with('product')
            ->get();
        return array(
            'customer'=>$customerDetails,
            'invoice'=>$invoiceTotal,
            'product'=>$invoiceProduct,
        );
    }
    //delete invoice
    public function DeleteInvoice(Request $request){
        DB::beginTransaction();
        try{
            $user_id=$request->header('id');
            $invoice_id=$request->input('inv_id');
            $invoiceproduct_id=$request->input('inv_id');
                  
            InvoiceProduct::where('invoice_id',$invoiceproduct_id)->where('user_id',$user_id)->delete();
            Invoice::where('id',$invoice_id)->delete();
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Invoice Deleted Successful',
            ],200);
        }catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'status' => 'fail',
                'message' => 'Invoice Not Deleted Successful',
            ],200);
        }

       
    }
}
