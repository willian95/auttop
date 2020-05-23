<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApprovedDiagnostic extends Model
{
    
    function diagnostic(){
        return $this->belongsTo('App\Diagnostic');
    }

    public function order(){
        return $this->belongsTo("App\Order");
    }

}
