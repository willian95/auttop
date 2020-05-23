<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    
    protected $fillable = [
        "patent", "brand", "model", "color", "year"
    ];

    public function orders(){
        return $this->hasMany("App\Order");
    }

}
