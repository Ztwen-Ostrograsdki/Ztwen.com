<?php


namespace App\Helpers;

use App\Models\User;
use App\Models\Product;
use App\Models\ShoppingBag;
use App\Models\SeenLikeProductSytem;
use Illuminate\Support\Facades\Auth;

trait ProductManager{

    /**
     * Use to like a target Products|Categories|Others
     *
     * @param string $target
     * @param int $target_id
     * @param int $user_id
     * @return void
     */
    public function likedThis($target = 'product', $target_id, $user_id = null)
    {
        if(!$user_id){
            $user = Auth::user();
        }
        else{
            $user = User::find($user_id);
        }

        if($target == 'product'){
            $product = Product::find($target_id);
            $seen = $product->seen;
            if($user){
                $product->update(['seen' => $seen + 1]);
                SeenLikeProductSytem::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'reaction' => true,
                ]);
                return true;
            }
            else{
                $product->update(['seen' => $seen + 1]);
                SeenLikeProductSytem::create([
                    'product_id' => $product->id,
                    'reaction' => true,
                ]);
                return true;
            }
        }
        
    }

    public function addToCart($product_id, $user_id = null)
    {
        if(!$user_id){
            $user = Auth::user();
        }
        else{
            $user = User::find($user_id);
        }

        if($user){
            $product = Product::find($product_id);
            if($product && !$user->alreadyIntoCart($product->id)){
                $panier = ShoppingBag::create(['user_id' => $user->id, 'product_id' => $product->id]);
                return true;
            }
            else{
                return false;
            }

        }
        else{
            return redirect(route('login'));
        }
    }


    public function deleteFromCart($product_id, $user_id = null)
    {
        if(!$user_id){
            $user = Auth::user();
        }
        else{
            $user = User::find($user_id);
        }
        if($user){
            $product = Product::find($product_id);
            if($product && $user->alreadyIntoCart($product->id)){
                $shop = ShoppingBag::where('user_id', $user->id)->where('product_id', $product->id);
                if($shop->get()->count() > 0){
                    $action  = $shop->first()->delete();
                    if($action){
                        return true;
                    }
                    return false;
                }
            }
            else{
                return abort(403, "Votre requête ne peut aboutir");
            }
        }
        else{
            return redirect(route('login'));
        }
        
    }









}