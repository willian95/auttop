<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;

class DashboardController extends Controller
{
    
    function index(){
        return view('admin.dashboard');
    }

    function mechanicIndex(){
        return view('mechanic.dashboard');
    }

    function deliveryIndex(){
        return view('delivery.dashboard');
    }

    function create(){
        return view('admin.orders.create');
    }

    function take(){
        try{

            $orders = Order::with('status', 'car', 'user', 'client', 'payments')->whereHas("car", "user")->where('status_id', '<', 12)->take(10)->orderBy('id', 'desc')->get();
            return response()->json(["success" => true, "orders" => $orders]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }
    }

}
