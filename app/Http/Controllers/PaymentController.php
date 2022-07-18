<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe,Session,App\Models\StripeTransaction;
use Razorpay\Api\Api,Exception;
use App\Models\Transaction;
use App\Models\UserOrder;

class PaymentController extends Controller
{

    /************************* RazorPay Payement Work ****************************/
    public function razorPayPaymentView(Request $req)
    {
        $key = env('RAZORPAY_KEY');
        $route = route('razorpay.payment.store');
        $token = csrf_field();
        $form = <<<EOF
            <form action="$route" method="POST">
            $token
                <script src="https://checkout.razorpay.com/v1/checkout.js"
                        data-key="$key"
                        data-amount="1000"
                        /****data-buttontext="Pay 100 INR"****/
                        data-name="Pro Music Tutor"
                        data-description="All downloads available in FULL HD or stream"
                        data-image="{{asset('defaultImages/logo.jpeg')}}"
                        /*data-prefill.name=""
                        data-prefill.email=""*/
                        data-theme.color="#ff7529">
                </script>
            </form>
        EOF;
        return $form;
        return view('payment.razorpay.index');
    }

    public function storerazorePayPayment(Request $req)
    {
        $req->validate([
            'stripeToken' => 'required|string',
            'amount' => 'required',
            'redirectURL' => 'required|string',
            'currency' => 'required|string',
        ]);
        \Stripe\Stripe::setApiKey('sk_test_4eC39HqLyjWDarjtT1zdp7dc');
        $payment = \Stripe\Charge::create ([
            "amount" => 100 * $req->amount,
            "currency" => $req->currency,
            "source" => $req->stripeToken,
            "description" => "Test payment",
        ]);
        if($payment->status == 'succeeded'){
            // user order save
            $order = new UserOrder();
            $order->user_id = auth()->user()->id;
            $order->transactionId = $payment->id;
            $order->amount = $payment->amount;
            $order->currency = emptyCheck($payment->currency);
            $order->order_id = emptyCheck($payment->balance_transaction);
            $order->save();

            // transaction save
            $newPayment = new Transaction();
            $newPayment->transactionId = $payment->id;
            $newPayment->order_id = emptyCheck($payment->balance_transaction);
            $newPayment->amount = $payment->amount;
            $newPayment->currency = emptyCheck($payment->currency);
            $newPayment->status = emptyCheck($payment->status);
            $newPayment->captured = emptyCheck($payment->captured);
            $newPayment->description = emptyCheck($payment->description);
            $newPayment->method = $payment->payment_method;
            $newPayment->amount_refunded = emptyCheck($payment->amount_refunded);
            $newPayment->refund_status = emptyCheck($payment->refunded);
            $newPayment->created_at_time = $payment->created;
            $newPayment->bank = $payment->payment_method_details->type;
            $newPayment->save();
            return redirect($req->redirectURL.'?transactionId='.$newPayment->id);
        }
        $error['stripePaymentGateway'] = 'Something went wrong please try after some time';
        return back()->withErrors($error)->withInput($req->all());
    }

    public function storerazorePayPaymentOLD(Request $req)
    {
        $req->validate([
            'razorpay_payment_id' => 'required|string',
            'redirectURL' => 'required',
        ]);
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $payment = $api->payment->fetch($req->razorpay_payment_id);
        if($payment){
            try{
                $response = $payment->capture(array('amount'=>$payment['amount']));
                if($response){
                    $newPayment = new Transaction();
                    $newPayment->transactionId = $response->id;
                    $newPayment->entity = emptyCheck($response->entity);
                    $newPayment->amount = $response->amount;
                    $newPayment->currency = emptyCheck($response->currency);
                    $newPayment->status = emptyCheck($response->status);
                    $newPayment->order_id = emptyCheck($response->order_id);
                    $newPayment->invoice_id = emptyCheck($response->invoice_id);
                    $newPayment->international = emptyCheck($response->international);
                    $newPayment->method = emptyCheck($response->method);
                    $newPayment->amount_refunded = emptyCheck($response->amount_refunded);
                    $newPayment->refund_status = emptyCheck($response->refund_status);
                    $newPayment->captured = emptyCheck($response->captured);
                    $newPayment->description = emptyCheck($response->description);
                    $newPayment->card_id = emptyCheck($response->card_id);
                    $newPayment->bank = emptyCheck($response->bank);
                    $newPayment->wallet = emptyCheck($response->wallet);
                    $newPayment->vpa = emptyCheck($response->vpa);
                    $newPayment->email = emptyCheck($response->email);
                    $newPayment->contact = emptyCheck($response->contact);
                    $newPayment->created_at_time = $response->created_at;
                    $newPayment->save();
                    return redirect($req->redirectURL.'?transactionId='.$newPayment->id);
                }else{
                    return response()->json(['error' => true,'message' => 'Something went wrong please try after some time']);
                }
            }catch(Exception $e){
                return response()->json(['error' => true,'message' => $e->getMessage()]);
            }
        }
        return response()->json(['error' => true,'message' => 'Payment Not done, your money will be refunded withing 7 days']);
    }

    /************************* Stripe Payement Work ****************************/
    public function stripeView(Request $req)
    {
        $data = [
            'redirectUrl' => '', //redirect URL will be here
            'price' => 100, // price wil be here
        ];
        return view('payment.stripe.index',compact('data'));
    }

    public function stripePostForm_Submit(Request $req)
    {
        $req->validate([
            '_token' => 'required',
            'stripeToken' => 'required',
            'amount' => 'required',
            'redirectURL' => 'required',
        ]);
        // dd($req->all());
        \Stripe\Stripe::setApiKey('sk_test_4eC39HqLyjWDarjtT1zdp7dc');
        $payment = \Stripe\Charge::create ([
            "amount" => 100 * $req->amount,
            "currency" => "usd",
            "source" => $req->stripeToken,
            "description" => "Test payment from http://switcher.com",
        ]);
        if($payment->status == 'succeeded'){
            $stripe = new StripeTransaction;
            $stripe->transactionId = $payment->id;
            $stripe->balance_transaction = $payment->balance_transaction;
            $stripe->amount = $payment->amount;
            $stripe->description = $payment->description;
            $stripe->payment_method = $payment->payment_method;
            $stripe->card_type = $payment->payment_method_details->type;
            $stripe->exp_month = $payment->payment_method_details->card->exp_month;
            $stripe->exp_year = $payment->payment_method_details->card->exp_year;
            $stripe->last4 = $payment->payment_method_details->card->last4;
            $stripe->save();
            return redirect($req->redirectURL.'?stripeTransactionId='.$stripe->id);
        }
        return back();
    }

    public function thankyouPayment(Request $req,$transactionId)
    {
        $stripe = StripeTransaction::findOrfail($transactionId);
        return view('payment.stripe.thankyou',compact('stripe'));
    }

    public function paymentFailure(Request $request)
    {
        return view('payment.paypal.failure');
    }

    public function paypalPaymentSave(Request $request)
    {
        // dd($request->all());
        $ch = curl_init();
        // remove "sandbox" from URL when live
        curl_setopt($ch, CURLOPT_URL, 'https://api-m.sandbox.paypal.com/v1/oauth2/token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
        // {client_id}:{client_secret}
        // curl_setopt($ch, CURLOPT_USERPWD, '{client_id}:{client_secret}');
        // PROD
        curl_setopt($ch, CURLOPT_USERPWD, '{AWpRwHkC7M1TJ2hiPWUhD9kj5sAw0EZNN_ozScNbTyvHxm2Ntx4rOgoO_uG4H4PrGNB3C1y-iMbLWuQ_}:{EJ3ltnidetYNj2RPjtfYUKceO-w0m02LQdYj9sZ996_uX_NpgimMC1eyIcE8Ewl3uc3t6IF1kgDq_FWC}');
        // SANDBOX
        // curl_setopt($ch, CURLOPT_USERPWD, '{Adqys1kmmR1q-yFM-f4GLdU2uirN1uVPcGBiksWNrqfI1DDTfza1uJk8pyvOQro00YzQqaYTFPcB9rCi}:{ELicq2zxGZAXzWzSH0gvDzBjGTe0ZdY0lNGDtrVBCmfDcA2Oo9ciDOXJRSCOyMS7SM5YCWO6mn6tbOPx}');

        // Headers
        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Accept-Language: en_US';
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);

        // dd(json_decode($result));

        $result = json_decode($result);

        // Token generate err are caught here
        /* if (curl_errno($ch)) {
            echo json_encode([
                "status" => "error",
                "message" => curl_error($ch)
            ]);
            exit();
        } */

        if (!empty($result->error)) {
            return response()->json([
                "status" => "error",
                "message" => $result->error_description
            ]);
        }

        curl_close($ch);

        // Response
        // $result = json_decode($result);
        // dd($result);
        $access_token = $result->access_token;

        // Only need the second part of orderID
        $payment_token_parts = explode("-", $_POST["orderID"]);
        $payment_id = "";

        if (count($payment_token_parts) > 1) {
            $payment_id = $payment_token_parts[1];
        }

        // initialize another CURL for verifying the order
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://api-m.sandbox.paypal.com/v2/checkout/orders/'.$payment_id);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');

        // Headers
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: Bearer ' . $access_token;
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($curl);

        // check for error
        if (curl_errno($curl))
        {
            // echo json_encode([
            //     "status" => "error",
            //     "message" => "Payment not verified. " . curl_error($curl)
            // ]);
            // exit();

            return response()->json([
                "status" => "error",
                "message" => "Payment not verified. " . curl_error($curl)
            ]);
        }
        curl_close($curl);
        $result = json_decode($result);

        // you can use the following if statement to make sure the payment is verified
        if ($result->status == "COMPLETED") {
            // send the response back to client
            echo json_encode([
                "status" => "success",
                "message" => "Payment verified.",
                "result" => $result
            ]);
            exit();
        }
    }
}
