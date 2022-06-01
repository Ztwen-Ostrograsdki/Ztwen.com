<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class BlockTemporaryMyAccount extends Controller
{

    public function __locked(Request $request)
    {
        $id = $request->id;
        if($id){
            $user = User::find($id);
            if($user){
                $user->disconnectUserForSecure();
                $user->markEmailAsUnVerified();
            }
            else{
                return abort(403);
            }
        }
        return abort(404);
    }
    






}
