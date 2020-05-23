<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diagnostic extends Model
{
    public function order(){
        return $this->belongsTo("App\Order");
    }

    public function service(){
        return $this->belongsTo(Service::class);
    }
}
