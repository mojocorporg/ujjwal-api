<?php

namespace App\Http\Controllers\API;

use App\Models\Rule;
use Razorpay\Api\Api;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Razorpay\Api\Errors\SignatureVerificationError;

class PaymentController extends Controller
{
    public function index()
    {
        $payment=Rule::first();
        return response()->json([
            'data'=>[
                'price'=>$payment->price,
                'contacts_on_payment'=>$payment->on_payment           
            ]
        ]);
    }

    public function order()
    {
        $user=auth()->user();
        $payment=Rule::first();

        if($payment->price > 0){
            $api_key = \Config::get('razorpay.api_key');
            $api_secret = \Config::get('razorpay.secret');
            $api = new Api($api_key, $api_secret);
    
            $razor_order = $api->order->create([
                'receipt' => "#receipt/$user->id",
                'amount' => $payment->price  * 100,
                'payment_capture' => 1,
                'currency' => 'INR',
            ]);

            if ($razor_order) {
                $user->transactions()->create([
                    'razorpay_order_id'=>$razor_order->id,
                    'price'=>$payment->price
                ]);
                return response()->json(['status' => true, 'message' => "Order Created successfully",'razorpay_order_id'=>$razor_order->id,'price'=>$payment->price]);
            }
            else
            return response()->json(['status' => false, 'message' => "Razorpay didn't respond, try again later"]);
        }
        return response()->json(['status' => false, 'message' => "Something went wrong, try again later"]);
    }

    public function verify_payment(Request $request)
    {
        $request->validate([
            'razorpay_payment_id' => 'required',
            'razorpay_order_id' => 'required',
            'razorpay_signature' => 'required',
        ]);

        $transaction = Transaction::where('razorpay_order_id', $request->razorpay_order_id)->first();
        $success=false;
        $error="Something went wrong";
        $user=$request->user();
        $payment=Rule::first();
        if($transaction){
            try
            {
                $api_key = \Config::get('razorpay.api_key');
                $api_secret = \Config::get('razorpay.secret');
                $api = new Api($api_key, $api_secret);
                $attributes = ['razorpay_signature' => $request->razorpay_signature, 'razorpay_payment_id' => $request->razorpay_payment_id, 'razorpay_order_id' => $request->razorpay_order_id];
                $api->utility->verifyPaymentSignature($attributes);
                $success = true;
                
                $transaction->update([
                    'razorpay_order_id' => $request->razorpay_order_id,
                    'razorpay_payment_id' => $request->razorpay_payment_id,
                    'razorpay_signature' => $request->razorpay_signature,
                    'status' => 'paid',
                ]);
            } catch (SignatureVerificationError $e) {
                $success = false;
                $error = 'Razorpay Error : ' . $e->getMessage();
                $transaction->update([
                    'status' => 'failed',
                    'remark'=>$error
                ]);
            }
        }
        if ($success === true) {
            return response()->json(['status' => true, 'message' => 'Payment successful, '.$payment->on_payment.' more contacts added.']);
        } else {
            return response()->json(['status' => false, 'message' => $error]);
        }
    }
}
