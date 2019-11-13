<?php

namespace App;

use App\Cart;
use App\Inventory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['name','price'];

    public function generateInventory(){
        $items = $this->all();
        foreach($items as $item){
            Inventory::create([
                'item_id'=>$item->id,
                'qty'=>rand(0,100)
            ]);
        }
    }
    public function inventory(){
        return $this->hasOne(Inventory::class);
    }
    
    public function cart(){
        return $this->belongsToMany(Cart::class);
    }
}
