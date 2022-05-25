<?php

namespace App\Helpers\ActionsTraits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

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


    public function __truncateModel($classMapping, $authorization = false)
    {
        if($authorization){
            Schema::disableForeignKeyConstraints();
            $classMapping::truncate();
            Schema::enableForeignKeyConstraints();
            return true;
        }
        return false;
    }


    public function __blockThisUser()
    {
        $action = $this->update(['blocked' => true]);
        if($action){
            return true;
        }
        return false;
    }
    public function __unblockThisUser()
    {
        $action = $this->update(['blocked' => false]);
        if($action){
            return true;
        }
        return false;
    }









}

