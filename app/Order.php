<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    
    public function client(){
        return $this->belongsTo("App\Client");
    }

    public function car(){
        return $this->belongsTo("App\Car");
    }

    public function status(){
        return $this->belongsTo("App\Status");
    }

    public function user(){
        return $this->belongsTo("App\User");
    }

    public function mechanic(){
        return $this->belongsTo("App\User", "mechanic_id");
    }

    public function diagnostic(){
        return $this->hasMany("App\Diagnostic");
    }

    public function approvedDiagnostic(){
        return $this->hasMany("App\ApprovedDiagnostic");
    }

    public function payments(){
        return $this->hasMany("App\Payment");
    }

}
