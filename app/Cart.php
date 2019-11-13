<?php

namespace App;

use App\Item;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id','item_id','qty'];  
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function items(){
        return $this::belongsTo(Item::class);
    }
}
