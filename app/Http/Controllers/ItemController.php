<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::orderBy('priority')->get();

        return view("items", compact("items"));
    }

    public function updateOrder(Request $request)
    {
        $input = $request->all();

        if (isset($input["order"])) {

            $order  = explode(",", $input["order"]);

            for ($i = 0; $i < count($order); $i++) {

                Item::where('id', $order[$i])->update(['priority' => $i]);
            }

            return json_encode([
                "status" => true,
                "message" => "Order updated"
            ]);
        }
    }
}
