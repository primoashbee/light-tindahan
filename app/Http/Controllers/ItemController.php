<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function apiFetch(){
        return Item::with('inventory')->get()->toJson();
    }
}
