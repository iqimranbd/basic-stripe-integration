<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController
{
    public function store(Request $request)
    {
        $price = $request->input('price');
        $product_name = $request->input('product_name');
        $stripe = new \Stripe\StripeClient(config('stripe.stripe_secret'));

        $response = $stripe->checkout->sessions->create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => ['name' => $product_name],
                        'unit_amount' => $price*100
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => route('success').'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('cancel'),
        ]);

        if(isset($response->id) && $response->id !=""){
            session()->put('product_name',$product_name);
            session()->put('quantity',1);
            session()->put('price',$price);
            return redirect($response->url);
        }else{
            return redirect()->route('cancel');
        }

    }

    public function show()
    {
        return view('welcome');
    }

    public function success(Request $request)
    {
        if(isset($request->session_id)){
            $stripe = new \Stripe\StripeClient(config('stripe.stripe_secret'));
            $response = $stripe->checkout->sessions->retrieve($request->session_id);
            //dd($response);

            $payment = new Payment();
            $payment->payment_id = $response->id;
            $payment->product_name = session()->get('product_name');
            $payment->quantity = session()->get('quantity');
            $payment->amount = session()->get('price');
            $payment->currency = $response->currency;
            $payment->customer_name = $response->customer_details->name;
            $payment->customer_email = $response->customer_details->email;
            $payment->payment_status = $response->status;
            $payment->payment_method = "stripe";
            $payment->save();

            //unset($request->session_id);
            session()->forget('product_name');
            session()->forget('quantity');
            session()->forget('price');

            return 'Payment Successfull';
        }else{
            return redirect()->route('cancel');
        }
    }

    public function cancel()
    {

    }

}
