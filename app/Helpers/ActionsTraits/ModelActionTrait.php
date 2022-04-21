<?php

namespace App\Helpers\ActionsTraits;

use Illuminate\Support\Facades\Auth;

trait ModelActionTrait{

    public function deleteThisModel($force = false)
    {
        $user = Auth::user();
        if($this->id && $user){
            if($user->role == 'admin' || $user->id == 1){
                if($force){
                    if($this->forceDelete()){
                        return true;
                    }
                    else{
                        return false;
                    }
                }
                else{
                    if($this->delete()){
                        return true;
                    }
                    else{
                        return false;
                    }
                }
            }
            else{
                return abort(403, "Vous n'êtes pas authorisé!");
            }
        }
        else{
            return abort(403, "Vous n'êtes pas authorisé!");
        }
    }
    
    public function restoreThisModel()
    {
        $user = Auth::user();
        if($this->id && $user){
            if($user->role == 'admin' || $user->id == 1){
                if($this->restore()){
                    return true;
                }
                else{
                    return false;
                }
            }
            else{
                return abort(403, "Vous n'êtes pas authorisé!");
            }
        }
        else{
            return abort(403, "Vous n'êtes pas authorisé!");
        }
    }









}

