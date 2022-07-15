<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Block;
use App\Models\User;

use Illuminate\Support\Facades\Auth;

class BlockController extends Controller
{
    public function checkblock(Request $request)
    {

        $block = Block::where('user_id',Auth::user()->id)
        ->Where('hotel_id',$request->hotel_id)
        ->first();



        if($block != null){

            $block->is_blocked = $request->blockAction;
            $block->update();
            return response(["message" => "Utilisateur à été déblocké avec succès"]);

        }else{

            $block= new Block;

                $block->user_id = Auth::user()->id;
                $block->hotel_id = $request->hotel_id;
                $block->is_blocked = $request->blockAction;
                $block->save();
                return response(["message" => "Utilisateur à été blocké avec succès"]);

        }

    }


}
