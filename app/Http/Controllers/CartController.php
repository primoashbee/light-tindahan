<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Events\AddedToCart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function apiFetch(){   
        return auth()->user()->cart();
    }
    public function apiAddToCart(Request $request){
        $request->validate([
            'item_id'=>'required|integer',
            'qty'=>'required|integer',
        ]);
        $cart = Cart::where('item_id','=',$request->item_id)
        ->where('user_id','=',auth()->user()->id)->first();
        if($cart===null){
            $cart = Cart::insert([
                'user_id'=>auth()->user()->id,
                'item_id'=>request()->item_id,
                'qty'=>request()->qty
            ]);
        }else{
            $total = $cart->qty;
            $total = $total + $request->qty;
            $cart = $cart->update([
                'qty'=>$total
            ]);
        }
        $response = array(['code'=>200,'msg'=>'Updated']);

        event(new AddedToCart($cart));
        return json_encode($response);

    }
    public function apiUpdateCart(Request $request){
        $request->validate([
            'item_id'=>'required|integer',
            'qty'=>'required|integer',
        ]);
        $cart = Cart::where('item_id','=',$request->item_id)
        ->where('user_id','=',auth()->user()->id)->first();
        if($cart===null){
            $cart = Cart::insert([
                'user_id'=>auth()->user()->id,
                'item_id'=>request()->item_id,
                'qty'=>request()->qty
            ]);
        }else{
            $cart = $cart->update([
                'qty'=>$request->qty
            ]);
        }
        $response = array(['code'=>200,'msg'=>'Updated']);

        event(new AddedToCart($cart));
        return json_encode($response);

    }
}
