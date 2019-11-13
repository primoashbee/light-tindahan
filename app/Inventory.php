<?php

namespace App;

use App\Item;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = ['item_id','qty'];
    
    public function item(){
        return $this->belongsTo(Item::class);
    }
}
