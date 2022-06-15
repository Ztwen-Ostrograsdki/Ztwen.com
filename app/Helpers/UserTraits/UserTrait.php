<?php

namespace App\Helpers\UserTraits;

use App\Models\MyNotifications;

trait UserTrait{

    public function __reporteThisUser()
    {
        
    }


    public function __backToUserProfilRoute()
    {
        return redirect()->route('user-profil', ['id' => $this->id]);
    }


    public function __getKeyNotification()
    {
        $notification = MyNotifications::where('user_id', $this->id)->where('target', 'Admin-Key')->first();
        if($notification){
            return $notification->content;
        }
        return "Aucune clé n'a été généré!";
    }

    
}