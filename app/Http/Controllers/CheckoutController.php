<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ApprovedDiagnostic;
use App\Cart;
use App\Payment;
use App\Order;

use Freshwork\Transbank\WebpayNormal;
use Freshwork\Transbank\WebpayPatPass;
use Freshwork\Transbank\RedirectorHelper;

use App\Traits\StoreOrderHistory;

class CheckoutController extends Controller
{
	use StoreOrderHistory;

    function cart(Request $request){

        try{

            $total = 0;
            foreach(ApprovedDiagnostic::with('diagnostic')->where('order_id', $request->orderId)->get() as $approved){
                $total = $total + floatval($approved->diagnostic->price);
            }

            if(Cart::where('order_id', $request->orderId)->count() <= 0){
				$cart = new Cart;
				$cart->order_id = $request->orderId;
				$cart->total = $total;
				$cart->save();
			}else{
				$cart = Cart::where("order_id", $request->orderId)->first();
			}

            return response()->json(["success" => true, "cartId" => $cart->id]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

    public function initTransaction($cartId, WebpayNormal $webpayNormal)
	{
        
        $total = Cart::find($cartId)->total;

		$order = rand(1000, 9999).uniqid();
		session(['cart' => $cartId]);
		session(["transfer" => $order]);

		$webpayNormal->addTransactionDetail(intval($total), $order);  
		$response = $webpayNormal->initTransaction(route('checkout.webpay.response'), route('checkout.webpay.finish')); 
		// Probablemente también quieras crear una orden o transacción en tu base de datos y guardar el token ahí.
		  
		return RedirectorHelper::redirectHTML($response->url, $response->token);
	}

	public function response(WebpayPatPass $webpayPatPass)  
	{  
		$result = $webpayPatPass->getTransactionResult();  
		session(['response' => $result]);

	  	// Revisar si la transacción fue exitosa ($result->detailOutput->responseCode === 0) o fallida para guardar ese resultado en tu base de datos. 
	
	  	$webpayPatPass->acknowledgeTransaction();

	  	return RedirectorHelper::redirectBackNormal($result->urlRedirection);  
	}

	public function finish()  
	{
	  	//dd($_POST, session('response'));  
	  	// Acá buscar la transacción en tu base de datos y ver si fue exitosa o fallida, para mostrar el mensaje de gracias o de error según corresponda
		$response = session('response');

		$cart = Cart::find(session('cart'));

		$payment = new Payment;
		$payment->order_id = $cart->order_id;
		$payment->transfer_id = session('tranfer');
		if($response->detailOutput->responseCode == 0){
			
			$payment->status = "aprobado";

			$order = Order::find($cart->order_id);
			$order->status_id = 7;
			$order->update();

			$this->storeHistory($order->id, $order->status_id);
			return view('user.payments.success', ["order" => $order]);

		}else{
			$payment->status = "rechazado";
			return view('user.payments.reject', ["order" => $order]);
		}
		$payment->save();

		

	}
}
