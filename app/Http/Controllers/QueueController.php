<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\Pharmacy;
use App\Models\Reception;
use App\Models\Synlab;
use App\Models\Vital;
use Illuminate\Http\Request;

class QueueController extends Controller
{
    public function addQueue(Request $request)
    {
        if($request->isMethod('post')){
            $billing = new Billing();
            $pharmacy = new Pharmacy();
            $reception = new Reception();
            $synlab = new Synlab();
            $vital = new Vital();       
            
            try{
                if ($request->has('billing')) {
                    $billing->billing = $request->billing;
                    $billing->save();
                }

                if ($request->has('pharmacy')) {
                    $pharmacy->pharmacy = $request->    pharmacy;
                    $pharmacy->save();
                }

                if ($request->has('reception')) {
                    $reception->reception = $request->reception;
                    $reception->save();
                }

                if ($request->has('synlab')) {
                    $synlab->synlab = $request->synlab;
                    $synlab->save();
                }

                if ($request->has('vital')) {
                    $vital->vital = $request->vital;
                    $vital->save();
                }
                return response()->json([
                    'success' => 'Queue Added Successfully',
                    'billing' => $billing,
                    'pharmacy' => $pharmacy,
                    'reception' => $reception,
                    'synlab' => $synlab,
                    'vital' => $vital
                ]);
            }catch(\Exception $e){
                return response()->json(['error' => $e->getMessage()], 500);
            }
           
        }   
    }
}
