<?php 
namespace App\Traits;

use App\OrderHistory;

trait StoreOrderHistory
{
    public function storeHistory($order_id, $status_id)
    {
        $orderHistory = new OrderHistory;
        $orderHistory->order_id = $order_id;
        $orderHistory->status_id = $status_id;
        $orderHistory->save();
    }

}