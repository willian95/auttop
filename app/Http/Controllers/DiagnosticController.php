<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Diagnostic;
use App\Service;
use App\Order;
use App\ApprovedDiagnostic;
use App\Traits\StoreOrderHistory;
use App\Traits\StoreWhatsappMessage;
use App\Traits\SendEmail;
use App\AdminEmail;

class DiagnosticController extends Controller
{
    use StoreOrderHistory;
    use StoreWhatsappMessage;
    use SendEmail;
    
    function check($id){
        return view('mechanic.orders.checkCar', ["orderId" => $id ]);
    }

    function store(Request $request){

        try{

            $previousCount = Diagnostic::where('order_id', $request->orderId)->count();
            $totalServices = Service::count();

            $actualCount = count($request->checkedServices);
            
            if($actualCount == ($totalServices - $previousCount)){

                foreach($request->checkedServices as $service){
                    
                    if($service["value"] >= 2){
                        $diagnostic = new Diagnostic;
                        $diagnostic->order_id = $request->orderId;
                        $diagnostic->price = 0;
                        $diagnostic->service_id = $service["serviceId"];
                        
                        if($service["value"] == 2){
                            $diagnostic->type = "sugerida";
                        }else if($service["value"] == 3){
                            $diagnostic->type = "urgente";
                        }

                        $diagnostic->observations = $service["obser"];
                        $diagnostic->save();
                    }
                    
                }

                $order = Order::find($request->orderId);
                $order->status_id = 4;
                $order->update();

                $this->storeHistory($order->id, $order->status_id);

                foreach(AdminEmail::all() as $email){

                    $data = ["body" => "Orden ".$order->id." diagnosticada", "link" => $order->link];
                    $this->sendEmail($email->email, $data, "Notificación de orden asignada");

                }

                return response()->json(["success" => true, "msg" => "Diagnostico agregado"]);

            }else{
                return response()->json(["success" => false, "msg" => "No ha marcado todos los servicios"]);
            }
                
        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function diagnostic($id){

        try{
            
            $order = Order::with('client', 'car')->findOrFail($id);
            return view("admin.diagnostic.index", ["order" => $order]);
        }
        catch(\Exception $e){

            return redirect()->back();

        }

    }

    function update(Request $request){

        try{

            $isFormComplete = true;
            foreach($request->prices as $price){
                if($price['price'] == "" || $price['price'] == null){
                    $isFormComplete = false;
                    break;
                }
            }

            if($isFormComplete == false){
                return response()->json(["success" => false, "msg" => "Debe colocar todos los precios"]);
            }
            //dd($request->prices);
            foreach($request->prices as $price){
                
                $diagnostic = Diagnostic::find($price['id']);
                $diagnostic->price = $price['price'];
                $diagnostic->update();           

            }

            $order = Order::find($request->orderId);
            $order->status_id = 5;
            $order->update();

            $this->storeHistory($order->id, $order->status_id);
            $this->storeMessage($order->client->telephone, "Hola ".$order->client->name.", tu auto está en proceso de pago. \n\n Puedes revisar el status en el siguiente link: ".url('order/number/'.$order->client_link));

            return response()->json(["success" => true, "msg" => "Diagnostico actualizado"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function approveDiagnostic(Request $request){
        
        try{

            foreach($request->approveDiagnostics as $diagnostic){

                $approvedDiagnostic = new ApprovedDiagnostic;
                $approvedDiagnostic->diagnostic_id = $diagnostic["id"];
                $approvedDiagnostic->order_id = $request->orderId;
                $approvedDiagnostic->save();

            }

            foreach(Diagnostic::where('order_id', $request->orderId)->where('type', "aprobada")->get() as $diagnostic){
                $approvedDiagnostic = new ApprovedDiagnostic;
                $approvedDiagnostic->diagnostic_id = $diagnostic->id;
                $approvedDiagnostic->order_id = $request->orderId;
                $approvedDiagnostic->save();
            }

            $order = Order::find($request->orderId);
            $order->status_id = 6;
            $order->update();

            $this->storeHistory($order->id, $order->status_id);

            return response()->json(["success" => true, "msg" => "Diagnostico actualizado"]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

}
