<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    
    use SoftDeletes;

    protected $fillable = [
        "rut", "name", "email", "telephone", "location", "address"
    ];

    public function orders(){
        return $this->hasMany("App\Order");
    }

}
