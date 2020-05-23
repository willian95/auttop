<?php 
namespace App\Traits;

use App\WhatsAppMessage;

trait StoreWhatsappMessage
{
    public function storeMessage($number, $message)
    {
        $wsmessage = new WhatsAppMessage;
        $wsmessage->number = $number;
        $wsmessage->message = $message;
        $wsmessage->save();
    }

}