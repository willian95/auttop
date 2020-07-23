<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\DiagnosticStoreRequest;
use App\Http\Requests\RevisionRequest;
use App\Traits\StoreOrderHistory;
use App\Traits\SendEmail;
use App\Traits\StoreWhatsappMessage;
use Illuminate\Support\Str;
use App\Order;
use App\Client;
use App\OrderHistory;
use App\ApprovedDiagnostic;
use App\Diagnostic;
use App\Payment;
use App\Car;
use App\User;
use App\AdminEmail;

class OrderController extends Controller
{
    
    use StoreOrderHistory;
    use StoreWhatsappMessage;
    use SendEmail;

    function index(){

        return view('admin.orders.index');

    }

    function create(){

        return view('user.orders.create');

    }

    function store(OrderStoreRequest $request){

        try{

            $client = Client::firstOrCreate(
                ['rut' => strtolower($request->rut)],
                ['name' => $request->name, 
                'telephone' => $request->telephone,
                'address' => $request->address,
                'location' => $request->commune,
                "email" => $request->email
                ]
            );

            $car = Car::firstOrCreate(
                ['patent' => strtolower($request->patent)],
                ['brand' => $request->brand, 
                'model' => $request->model,
                'year' => $request->year,
                "color" => $request->color
                ]
            );

            $order = new Order;
            $order->client_id = $client->id;
            $order->car_id = $car->id;
            $order->status_id = 1;
            $order->user_id = $request->delivery;
            $order->client_link = Str::random(30).uniqid();
            $order->save();

            foreach($request->services as $service){
                
                $diagnostic = new Diagnostic;
                $diagnostic->order_id = $order->id;
                $diagnostic->service_id = $service['service']['id'];
                $diagnostic->price = $service['price'];
                $diagnostic->type = "aprobada";
                $diagnostic->save();
                
            }

            $delivery = User::find($request->delivery);

            $this->storeHistory($order->id, $order->status_id);

            $data = ["body" => "Orden ".$order->id." asignada a ".$delivery->name, "link" => ""];
            $this->sendEmail($delivery->email, $data, "Orden asignada");

            foreach(AdminEmail::all() as $email){

                $data = ["body" => "Orden ".$order->id." asignada a ".$delivery->name, "link" => ""];
                $this->sendEmail($email->email, $data, "Notificación de orden asignada");

            }

            return response()->json(["success" => true, "msg" => "Orden creada"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function fetch($page = 1){
        try{

            $skip = ($page - 1) * 15;
            
            if(\Auth::user()->role_id == 2){
                $orders = Order::with('status', 'car', 'user', 'client', 'payments')->where('status_id', '>', 3)->has('client', 'car')->skip($skip)->take(15)->orderBy('id', 'desc')->get();
                $ordersCount = Order::with('status', 'car', 'user', 'client', 'payments')->has('client', 'car')->where('status_id', '>', 3)->count();
            }

            else if(\Auth::user()->role_id == 3){
                $orders = Order::with('status', 'car', 'user', 'client', 'payments')->where('status_id', '>=', 1)->has('client', 'car')->where('status_id', '<', 3)->skip($skip)->take(15)->orderBy('id', 'desc')->get();
                $ordersCount = Order::with('status', 'car', 'user', 'client', 'payments')->has('client', 'car')->where('status_id', '>=', 1)->where('status_id', '<', 3)->count();
            }

            else{
                $orders = Order::with('status', 'car', 'user', 'client', 'payments', 'mechanic')->has('client', 'car')->skip($skip)->take(15)->orderBy('id', 'desc')->get();
                $ordersCount = Order::with('status', 'car', 'user', 'client', 'payments', 'mechanic')->has('client', 'car')->count();
            }

            return response()->json(["success" => true, "orders" => $orders, "ordersCount" => $ordersCount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }
    }

    function confirmPayment($client_link){
        
        $order = Order::where('client_link', $client_link)->with('payments')->first();
        
        if($order->status_id == 9){
            return redirect()->back();
        }

        if($order != null){

            return view('confirmPayment', ["order" => $order]);

        }

    }

    function show($client_link){

        $order = Order::with('client', 'car', 'diagnostic', 'user')->where('client_link', $client_link)->first();

        if($order != null){

            return view('tracking', ["order" => $order]);

        }

    }

    function showPayment($client_link){

        $order = Order::where('client_link', $client_link)->first();

        if($order != null){

            return view('payment', ["order_id" => $order->id, "total" => $order->total, "order" => $order]);

        }

        return redirect()->back();

    }

    function getDiagnostics(Request $request){

        $diagnostics = Diagnostic::where('order_id', $request->order_id)->get();
        return response()->json($diagnostics);
    }

    function getAdminDiagnostics(Request $request){

        $diagnostics = Diagnostic::with('service')->where('order_id', $request->order_id)->get();
        return response()->json($diagnostics);
    }

    function cancel(Request $request){

        try{
            $order = Order::find($request->id);
            $order->status_id = 12;
            $order->update();

            $this->storeHistory($order->id, $order->status_id);
            
            return response()->json(["success" => true, "msg" => "Orden cancelada"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }

    }

    function notificationCarProcess(Request $request){

        try{

            $order = Order::find($request->id);
            $order->status_id = 3;
            $order->update();

            $this->storeHistory($order->id, $order->status_id);
            $this->storeMessage($order->client->telephone, "Hola ".$order->client->name.", tu auto está en proceso. \n\n Puedes revisar el status en el siguiente link: ".url('order/number/'.$order->client_link));

            return response()->json(["success" => true, "msg" => "Orden actualizada, notificación será enviada en breve"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }

    }

    function notificationCarOnDelivery(Request $request){

        try{

            $order = Order::find($request->id);
            $order->status_id = 8;
            $order->update();

            $this->storeHistory($order->id, $order->status_id);
            //$this->storeMessage($order->client->telephone, "Hola ".$order->client->name.", tu auto va camino a tu lugar. \n\n Puedes revisar el status en el siguiente link: ".url('order/number/'.$order->client_link));

            return response()->json(["success" => true, "msg" => "Orden actualizada"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }

    }

    function notificationFinish(Request $request){

        try{

            $order = Order::find($request->id);
            $order->status_id = 9;
            $order->update();

            $this->storeHistory($order->id, $order->status_id);
            //$this->storeMessage($order->client->telephone, "Hola ".$order->client->name.", tu auto va camino a tu lugar. \n\n Puedes revisar el status en el siguiente link: ".url('order/number/'.$order->client_link));

            return response()->json(["success" => true, "msg" => "Orden actualizada"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }

    }

    function search($search){

        /*$clientsArray = [];
        $clients =  Client::where('rut', 'like', '%'.$rut.'%')->get();
        
        foreach($clients as $client){
            array_push($clientsArray, $client->id);
        }*/

        //$orders = Order::whereIn('client_id', $clientsArray)->with('status', 'car', 'user', 'client', 'payments')->orderBy("id", "desc")->get();
        $orders = Order::whereHas("client", function ($query) use($search) {
                
            $query->where('rut', "like", "%".$search."%");
        
        })->orWhereHas('car', function( $query ) use ( $search ){

            $query->where('patent', "like", "%".$search."%" );

        })->with('status', 'car', 'user', 'client', 'payments')->orderBy("id", "desc")->get();

        return response()->json(["success" => true, "orders" => $orders]);

    }

    function mechanicFetch($page = 1){

        try{

            $skip = ($page - 1) * 20;

            $orders = Order::with('client', 'car', 'diagnostic', 'status')->where('status_id', '>=', 3)->where('status_id', '<', 9)->skip($skip)->take(20)->orderBy('id', 'desc')->get();
            $ordersCount = Order::with('client', 'car', 'diagnostic', 'status')->where('status_id', '>=', 3)->where('status_id', '<', 9)->count();

            return response()->json(["success" => true, "orders" => $orders, "ordersCount" => $ordersCount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function deliveryFetch($page = 1){

        try{

            $skip = ($page - 1) * 20;

            $orders = Order::where('user_id', \Auth::user()->id)->where('status_id', '<', 3)->with('client', 'car', 'diagnostic', 'status')->skip($skip)->take(20)->orderBy('id', 'desc')->get();
            $ordersCount = Order::where('user_id', \Auth::user()->id)->where('status_id', '<', 3)->with('client', 'car', 'diagnostic', 'status')->count();

            return response()->json(["success" => true, "orders" => $orders, "ordersCount" => $ordersCount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function deliveryEdit($order_id){

        try{

            $order = Order::where('id', $order_id)->with('client', 'car', 'diagnostic', 'status')->first();
            return view("delivery.orders.edit", ["order" => $order]);

        }catch(\Exception $e){
            
            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function mechanicServicesOrder($order_id){

        try{

            $services = Diagnostic::where('order_id', $order_id)->with('service')->get();
            return response()->json(["success" => true, "services" => $services]);

        }catch(\Exception $e){
            
            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function revision(RevisionRequest $request){

        try{

            $client = Client::where('rut', $request->rut)->first();
            $client->name = $request->name;
            $client->email = $request->email;
            $client->location = $request->location;
            $client->telephone = $request->telephone;
            $client->address = $request->address;
            $client->update();

            $car = Car::where('patent', $request->patent)->first();
            $car->brand = $request->brand;
            $car->model = $request->model;
            $car->year = $request->year;
            $car->color = $request->color;
            $car->update();

            $order = Order::find($request->orderId);
            $order->comments = $request->comments;
            $order->kilometers = $request->kilometers;
            $order->gas_amount = $request->gas_amount;
            $order->status_id = 2;
            $order->update();

            $this->storeHistory($order->id, $order->status_id);
            $this->storeMessage($client->telephone, "Hola ".$client->name.", tu auto va camino al taller. \n\n Puedes revisar el status en el siguiente link: ".url('order/number/'.$order->client_link));

            return response()->json(["success" => true, "msg" => "Order actualizada, se notificará al cliente"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

}
