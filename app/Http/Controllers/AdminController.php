<?php

namespace App\Http\Controllers;

use App\Models\Course\courseBatch;
use App\Models\Course\CourseEnrollment;
use App\Models\Course\Order;
use App\Models\Myaccount\InstitutionInfo;
use Carbon\Carbon;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class AdminController extends Controller
{
    public function dashboard() {
        $partnerLists = InstitutionInfo::select('id')->where('status',1)
        ->whereNotNull('order_number')
        ->whereNull('deleted_at')
        ->count();
        $courseBatches = courseBatch::select('id')
        ->where('type','course')
        ->whereNull('deleted_at')
        ->count();

        $totals = Order::selectRaw('YEAR(created_at) as year, SUM(amount) as total_amount, COUNT(*) as order_count')
                ->where('tran_amount', '>', 0)
                ->whereNotNull('tran_data')
                ->where('amount', '>', 0)
                ->groupBy('year')
                ->get();

        return view('admin.pages.dashboard',compact('partnerLists','courseBatches','totals'));
    }

    public function enroll(Request $request) {

        $partnerLists = InstitutionInfo::select('id','institution_name','institution_name_bn')
        ->where('status',1)
        ->has('courseBatche')
        ->whereNotNull('order_number')
        ->whereNull('deleted_at')
        ->get();

        if ($request->has('partner')) {
            $courseBatches = courseBatch::select('id','bn_title','title')
            ->where('type','course')
            ->where('owner_id',$request->partner)
            ->whereNull('deleted_at')
            ->get();
        }
        else{
            $courseBatches = courseBatch::select('id','bn_title','title')
            ->where('type','course')
            ->whereNull('deleted_at')
            ->get();
        }


        $startDate = $request->start_date ?? date('Y-01-01');
        $endDate = $request->end_date ?? date('Y-m-d');
        $startDate = Carbon::parse($startDate)->startOfDay();
        $endDate = Carbon::parse($endDate)->endOfDay();

        $datas = CourseEnrollment::with(['courseBatch:id,owner_id,uuid,bn_title,title','order:id,tran_amount,tran_data,transactionid,order_number,amount,payment_status,payment_method','user:id,name,bn_name,phone,email'])->whereBetween('created_at', [$startDate, $endDate]);

        if ($request->has('partner')) {
            $datas->whereHas('courseBatch', function ($courseBatchQuery) use($request) {
                $courseBatchQuery->where('owner_id',$request->partner);
            });
        }
        if ($request->has('course_batch')) {
            $datas = $datas->where('course_batch_id',$request->course_batch );
        }
        if ($request->has('status')) {
            $datas->whereHas('order', function ($Orderquery) use($request) {
                $Orderquery->where('payment_status',$request->status);

            });
        }


        $datas = $datas->whereHas('order', function ($Orderquery) {
                        $Orderquery->where('tran_amount', '>', 0);
                        $Orderquery->whereNotNull('tran_data');
                        $Orderquery->where('amount', '>', 0);
                    });
        $datas =  $datas->orderBy('id','desc')->paginate(50);

        return view('admin.pages.enrollment',compact('partnerLists','courseBatches','datas'));
    }

    public  function getPartnerCourse($id){

        $courseBatches = courseBatch::select('id','bn_title','title')
        ->where('type','course')
        ->where('owner_id',$id)
        ->whereNull('deleted_at')
        ->get();
        $html = View::make('admin.pages.dynamicdrop', compact('courseBatches'))->render();
        return response()->json(['html' => $html]);
    }
}
