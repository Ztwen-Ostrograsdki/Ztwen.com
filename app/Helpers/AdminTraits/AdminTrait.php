<?php

namespace App\Helpers\AdminTraits;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\UserAdminKey;
use App\Models\MyNotifications;

trait AdminTrait{

    /**
     * Use to regenerate or create a new admin into session who want to connect to the an amin route/dashboard
     * 
     * @return void
     */
    public function __regenerateAdminSession()
    {
        session()->put('admin-' . $this->id, $this->id);
    }


    /**
     *Deterline if a user with admin or master role have been already into session before access to admin routes
        *
        * @return bool
        */
    public function __hasAdminAuthorization()
    {
        if(session()->has('admin-' . $this->id) && session('admin-' . $this->id) == $this->id){
            $this->__regenerateAdminSession();
            return true;
        }
        return false;
    }


    /**
     * Use to destroy an session 
     *
     * @return void
     */
    public function __hydrateAdminSession()
    {
        session()->forget('admin-' . $this->id);
    }

    
    /**
     * Use to destroy all session data
     *
     * @return void
     */
    public function __destroyAdminSession()
    {
        session()->flush();
    }


    public function __sendKey()
    {
        MyNotifications::create([
            'content' => "Bienvenu(e) sur la plateforme. Nous vous envoyons la clé de connexion à la page d'administration. Clé: "  . auth()->user()->userAdminKey->key,
            'user_id' =>  auth()->user()->id,
            'target' => "Admin-Key",
            'target_id' => null
        ]);
    }


    public function __generateAdminKey()
    {
        $key = Str::random(4);
        if($this->hasAdminKey()){
            $make = $this->userAdminKey->update([
                'user_id' => $this->id,
                'key' => $key
            ]);
            if($make){
                $this->__refreshNotifications();
                return $this->__sendKey();
            }
        }
        else{
            $make = UserAdminKey::create([
                'user_id' => $this->id,
                'key' => $key
            ]);
            if($make){
                $this->__refreshNotifications();
                return $this->__sendKey();
            }
        }
    }


    public function __regenerateAdminKey()
    {
        return $this->__generateAdminKey();
    }


    public function __destroyAdminKey()
    {
        if($this->hasAdminKey()){
            $this->userAdminKey->delete();
        }
        $this->__hydrateAdminSession();
        $this->__refreshNotifications();
        $this->__backToUserProfilRoute();
    }

    public function hasAdminKey()
    {
        $key = $this->userAdminKey;

        if($key){
            return true;
        }
        return false;
    }


    public function __refreshNotifications()
    {
        $notifications = MyNotifications::where('user_id', $this->id)->where('target', 'Admin-Key');
        if($notifications->get()->count() > 0){
            return $notifications->delete();
        }
        
    }

    










}