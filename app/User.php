<?php

namespace App;

use App\Cart;

use Illuminate\Support\Facades\DB;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class User extends Authenticatable
{
    use Notifiable,LaravelVueDatatableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */ 
    protected $fillable = [
        'name', 'email', 'password','department_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function cart(){
     //   return $this->hasMany(Cart::class);
        //return 'haha';
        $id = auth()->user()->id;
        return DB::table('carts')
            ->where('user_id','=',$id)
            ->leftJoin('items','items.id','=','carts.item_id')
            ->leftJoin('inventories','items.id','=','inventories.item_id')
            ->selectRaw('carts.qty, carts.item_id, items.name, items.price, (carts.qty * items.price ) as total, inventories.qty as i_qty')
            ->get();
    }
}
