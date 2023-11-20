<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Date;

class SaleReportController extends Controller
{
    public function ReportPage():View{
        return view('pages.dashboard.report-page');
    }


    public function SalesReport(Request $request){
        $user_id=$request->header('id');
        $FormDate=date('Y-m-d',strtotime($request->FormDate));
        $ToDate=date('Y-m-d',strtotime($request->ToDate));

        $total=Invoice::where('user_id',$user_id)->whereDate('created_at', '>=', $FormDate)->whereDate('created_at', '<=', $ToDate)->sum('total');
        $vat=Invoice::where('user_id',$user_id)->whereDate('created_at', '>=', $FormDate)->whereDate('created_at', '<=', $ToDate)->sum('vat');
        $payable=Invoice::where('user_id',$user_id)->whereDate('created_at', '>=', $FormDate)->whereDate('created_at', '<=', $ToDate)->sum('payable');
        $discount=Invoice::where('user_id',$user_id)->whereDate('created_at', '>=', $FormDate)->whereDate('created_at', '<=', $ToDate)->sum('discount');
        
		$list=Invoice::where('user_id',$user_id)->whereDate('created_at', '>=', $FormDate)->whereDate('created_at', '<=', $ToDate)->with('customer')->get();

        $data=[
            'payable'=> $payable,
            'discount'=>$discount, 
            'total'=> $total,
             'vat'=> $vat, 
             'list'=>$list,
             'FormDate'=>$request->FormDate,
             'ToDate'=>$request->ToDate];
        $pdf = Pdf::loadView('report.sale-report',$data);
        return $pdf->download('invoice.pdf');

   


    }
}
