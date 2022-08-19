<?php

namespace App\Helpers\AdminTraits;

use Illuminate\Support\Str;
use App\Models\UserAdminKey;
use App\Models\MyNotifications;
use Illuminate\Support\Facades\Hash;


/**
 * Manage all about the admins
 */
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

     /**
     * This method is used to send the weak key to an admin after the key has been generated
     *
     * @param string $key
     * @return bool
     */
    public function __sendKey($key)
    {
        $make = MyNotifications::create([
            'content' => $key . " #Bienvenu(e) sur la plateforme. Nous vous envoyons la clé de connexion à la page d'administration. ",
            'user_id' =>  auth()->user()->id,
            'target' => "Admin-Key",
            'target_id' => null
        ]);
        if($make){
            return true;
        }
        else{
            return false;
        }
    }

    /**
     * This method is used to send the adavanced or strong key to an admin after the key has been generated
     *
     * @param string $key
     * @return bool
     */
    public function __sendAdvancedKey($key)
    {
        $make = MyNotifications::create([
            'content' => $key . " #Salut! Je vous envoie la clé des requêtes irreversibles dans la page d'administration." ,
            'user_id' =>  auth()->user()->id,
            'target' => "Admin-Advanced-Key",
            'target_id' => null
        ]);
        if($make){
            return true;
        }
        else{
            return false;
        }
    }

    /**
     * Use to generate a weak key
     *
     * @return void
     */
    public function __generateAdminKey()
    {
        $key = Str::random(4);
        if($this->hasAdminKey()){
            $this->__destroyWeakKeys();
            $this->__refreshNotifications();
        }
        $make = UserAdminKey::create([
            'user_id' => $this->id,
            'key' =>  Hash::make($key)
        ]);
        if($make){
            $this->__destroyStrongKeys();
            $this->__refreshNotifications();
            return $this->__sendKey($key);
        }
        return false;
    }

    /**
     * Use to generate a strong key
     *
     * @return bool
     */
    public function __generateAdvancedRequestKey()
    {
        $key = Str::random(4);
        if($this->hasAdminAdvancedKey()){
            $this->__destroyStrongKeys();
            $this->__refreshNotifications();
        }
        $make = UserAdminKey::create([
            'user_id' => $this->id,
            'key' =>  Hash::make($key)
        ]);
        $make->forceFill(['advanced' => true])->save();
        if($make){
            $this->__destroyWeakKeys();
            $this->__refreshNotifications();
            return $this->__sendAdvancedKey($key);
        }
        return false;
    }
    /**
     * Use to regenerate a strong key
     *
     * @return bool
     */
    public function __regenerateAdvancedRequestKey()
    {
        return $this->__generateAdvancedRequestKey();
    }


    /**
     * Use to regenerate a weak key
     *
     * @return void
     */
    public function __regenerateAdminKey()
    {
        return $this->__generateAdminKey();
    }


    /**
     * Use to destroy the current admin key and flush a session authentication
     * The admin can't access to the admin 
     *
     * @return void
     */
    public function __destroyAdminKey()
    {
        if($this->hasAdminKey()){
            $this->userAdminKey->delete();
        }
        $this->__hydrateAdminSession();
        $this->__refreshNotifications();
        $this->__backToUserProfilRoute();
    }
    
    /**
     * Use to destroy all admin keys that aren't avanced keys
     *
     * @return void
     */
    public function __destroyWeakKeys()
    {
        $weak_keys = UserAdminKey::where('user_id', $this->id)->where('advanced', false);
        if($weak_keys->get()->count() > 0){
            $weak_keys->delete();
        }
    }


    /**
     * Use to destroy all advanced adamin keys
     *
     * @return void
     */
    public function __destroyStrongKeys()
    {
        $strong_keys = UserAdminKey::where('user_id', $this->id)->where('advanced', true);
        if($strong_keys->get()->count() > 0){
            $strong_keys->delete();
        }
    }

    /**
     * Determine if an admin has a weak admin key
     *
     * @return boolean
     */
    public function hasAdminKey()
    {
        $key = $this->userAdminKey;

        if($key){
            return true;
        }
        return false;
    }

    /**
     * Determine if an admin has a strong admin key or an advanced admin key
     *
     * @return boolean
     */
    public function hasAdminAdvancedKey()
    {
        $key = $this->userAdminKey;

        if($key && $key->advanced){
            return true;
        }
        return false;
    }


    /**
     * Use to refresh all notification about the admin key: strong and weak
     *
     * @return void
     */
    public function __refreshNotifications()
    {
        $notifications = MyNotifications::where('user_id', $this->id)->where('target', 'Admin-Key')->orWhere('target', 'Admin-Advanced-Key');
        if($notifications->get()->count() > 0){
            return $notifications->delete();
        }
        
    }

}