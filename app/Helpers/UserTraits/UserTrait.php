<?php

namespace App\Helpers\UserTraits;

trait UserTrait{

    public function __reporteThisUser()
    {
        
    }


    public function __backToUserProfilRoute()
    {
        return redirect()->route('user-profil', ['id' => $this->id]);
    }

    
}