<?php

namespace App\Helpers\UserTraits;

use App\Models\Product;
use App\Models\ShoppingBag;
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

    public function __getAdvancedKeyNotification()
    {
        $notification = MyNotifications::where('user_id', $this->id)->where('target', 'Admin-Advanced-Key')->first();
        if($notification){
            return $notification->content;
        }
        return "Aucune clé n'a été généré!";
    }



    /**
     * Determine if a product was added into the user's cart
     *
     * @param int $product_id
     * @return bool
     */
    public function __alreadyIntoMyCart($product_id)
    {
        $product = Product::find($product_id);
        if($product){
            $alreadyIntoCart = ShoppingBag::where('user_id', $this->id)->where('product_id', $product->id)->get();
            if($alreadyIntoCart->count() > 0){
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return abort(403, "Votre requête ne peut aboutir");
        }
    }

    
}