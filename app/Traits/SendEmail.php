<?php

namespace App\Traits;

trait SendEmail
{
    public function sendEmail($email, $data, $subject)
    {
        \Mail::send("emails.notification", $data, function($message) use ($email, $subject) {// se envía el email

            $message->to($email)->subject($subject);
            $message->from("rodriguezwillian95@gmail.com","Auttop");

        });
    }

}