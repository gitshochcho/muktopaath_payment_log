<?php

namespace App\Http\Controllers;

use App\Models\Course\Order;
use App\Models\EkPayOrderDetail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use PhpParser\Node\Stmt\TryCatch;

class EkpayChaqueController extends Controller
{
    public function paymentDetails()
    {
        // $countResult = Order::whereNotNull("tran_data")->pluck('id');
        // $localResult = EkPayOrderDetail::whereNotNull("tran_data")->pluck('id');

        // $collection1 = collect($countResult);
        // $collection2 = collect($localResult);

        // $difference = $collection1->diff($collection2)->values();

        // dd($difference);

        $countResult = Order::whereNotNull("tran_data")
        ->where('id','>',8733407)
        ->chunk(1000, function ($orders) {
            foreach ($orders as $order) {
                // You can manipulate the data if needed before inserting into the new table
                $data = $order->toArray();

                // Set the 'order_created_at' column to the value of 'created_at'
                $data['order_created_at'] = Carbon::parse($data['created_at'])->format('Y-m-d');
                $data['order_update_at'] = Carbon::parse($data['updated_at'])->format('Y-m-d');
                $data['created_at'] = Carbon::now();
                $data['updated_at'] = Carbon::now();

                // Insert into the new table
                EkPayOrderDetail::insert($data);
            }

        });
            $result = EkPayOrderDetail::count();
        dd($result);
    }

    public function getEkpayResponse()
    {
        // 8734047
        // dd("success");
        set_time_limit(0);
        // $results = EkPayOrderDetail::select('tran_data','id')->whereNotNull("tran_data")->where('tran_amount','>',0)->where('id','>',2909213)->get();

        $results = EkPayOrderDetail::select('tran_data','id')->whereNotNull("tran_data")
                        ->where('tran_amount','>',0)
                        ->where('id','>',8733407)
                        // ->where('id','<',8734098)
                        // ->where('id',8734098)
                        // ->whereIn('id',[8732868,8737535])
                        ->chunk(25, function ($results) {
                            foreach ($results as $key => $result) {
                            $tranDataArray = json_decode($result->tran_data);
                            // $tranDate = date('Y-m-d', strtotime($tranDataArray?->req_timestamp));
                            $tranDate = date('Y-m-d', strtotime($tranDataArray?->pi_det_info->pay_timestamp));
                            $checkId = $tranDataArray?->trnx_info?->mer_trnx_id;
                            $apiUrl = "https://pg.ekpay.gov.bd/ekpaypg/v1/get-status";

                            try {

                                $response = Http::post($apiUrl, [
                                    'trnx_id' =>  $checkId,
                                    'trans_date' =>$tranDate,
                                ]);
                                if ($response->successful()) {

                                    $dataUpdate = array(
                                        "ekpay_detail" => $response->json()
                                    );
                                    $ekPay = EkPayOrderDetail::find($result->id);
                                    $ekPay->update($dataUpdate);


                                }
                            } catch (\Throwable $th) {

                            }
                        }
        });

    }
}
