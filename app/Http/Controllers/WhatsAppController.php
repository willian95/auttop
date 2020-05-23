<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\WhatsAppMessage;
use App\Traits\StoreOrderHistory;
use App\OrderHistory;
use App\Order;
use App\Client;

class WhatsAppController extends Controller
{
    
    use StoreOrderHistory; 

    function sendMessage(Request $request){
        
        if($request->pass == "whatsup"){
            $messages = WhatsAppMessage::where('sended', false)->get();
            $messages2 = WhatsAppMessage::where('sended', false)->get();

            foreach($messages2 as $message){

                $msg =  WhatsAppMessage::find($message->id);
                $msg->sended = true;
                $msg->update();

            }

            return response()->json($messages);
        }
        
    }

}
