<?php


namespace App\Helpers\ProductsTraits;

use App\Models\User;
use App\Models\Product;
use App\Models\ShoppingBag;
use App\Models\SeenLikeProductSytem;
use Illuminate\Support\Facades\Auth;

trait ProductTrait{

    /**
     * Use to like a target Products|Categories|Others
     *
     * @param string $target
     * @param int $target_id
     * @param int $user_id
     * @return void
     */

    public function __likedThis($target = 'product', $target_id, $user_id = null)
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

    /**
     * Use to add a product into the user's cart
     *
     * @param int|null $user_id
     * @return bool
     */
    public function __addToUserCart($user_id = null)
    {
        $errors = [];
        if(!$user_id){
            $user = Auth::user();
        }
        else{
            $user = User::find($user_id);
        }
        if($user){
            $product = $this;
            if($product && !$this->__alreadyIntoCartOfThisUser()){
                $add_to_cart = ShoppingBag::create(['user_id' => $user->id, 'product_id' => $product->id]);
                if($add_to_cart){
                    return true;
                }
                else{
                    $errors = [
                        'title' => 'Erreur serveur !',
                        'message' => "L'ajout de l'article {$product->getName()} à votre panier a échoué !",
                        'type' => "error",
                    ];
                    $this->livewire_product_errors = $errors;
                    return false;
                }
            }
            else{
                $errors = [
                    'title' => 'Article déjà ajouté!',
                    'message' => "Cet article est déjà dans votre panier!",
                    'type' => "info",
                ];
                $this->livewire_product_errors = $errors;
                return false;
            }

        }
        else{
            $errors = [
                'title' => 'Connexion requise!',
                'message' => "Veuillez vous connecter avant d'exécuter cette action! ",
                'type' => "warning",
            ];
            $this->livewire_product_errors = $errors;
            return false;
        }
    }


    /**
     * Use to retrieve a product into the user's cart
     *
     * @param int|null $user_id
     * @return bool
     */
    public function __retrieveFromUserCart($user_id = null)
    {
        $errors = [];
        if(!$user_id){
            $user = Auth::user();
        }
        else{
            $user = User::find($user_id);
        }
        if($user){
            $product = $this;
            if($product && $this->__alreadyIntoCartOfThisUser()){
                $shop = ShoppingBag::where('user_id', $user->id)->where('product_id', $this->id);
                if($shop->get()->count() > 0){
                    $action  = $shop->first()->delete();
                    if($action){
                        return true;
                    }
                    else{
                        $errors = [
                            'title' => 'Erreur serveur!',
                            'message' => "L'article : {$product->getName()} n'a pas pu être retirer de votre panier, veuillez réessayer !",
                            'type' => "error",
                        ];
                        $this->livewire_product_errors = $errors;
                        return false;
                    }
                }
                else{
                    $errors = [
                        'title' => 'Oupps article inconnue !',
                        'message' => "Cet l'article : {$product->getName()} ne fait pas partir votre panier !",
                        'type' => "warning",
                    ];
                    $this->livewire_product_errors = $errors;
                    return false;
                }
            }
            else{
                $errors = [
                    'title' => 'Ouups article inconnue !',
                    'message' => "Cet l'article : {$product->getName()} ne fait pas partir votre panier !",
                    'type' => "warning",
                ];
                $this->livewire_product_errors = $errors;
                return false;
            }
        }
        else{
            $errors = [
                'title' => 'Connexion requise!',
                'message' => "Veuillez vous connecter avant d'exécuter cette action! ",
                'type' => "warning",
            ];
            $this->livewire_product_errors = $errors;
            return false;
        }
    }


    /**
     * Determine if a product has been into the cart of a user
     *
     * @param int|null $user_id
     * @return bool|' h a n d l e an HTTP error'
     */
    public function __alreadyIntoCartOfThisUser($user_id = null)
    {
        if($user_id){
           $user = User::find($user_id);
        }
        else{
            $user = Auth::user();
        }
        if($user){
            $alreadyIntoCart = ShoppingBag::where('user_id', $user->id)->where('product_id', $this->id)->get();
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


    public function __getCarts()
    {
        $carts = [];
        $products = Product::all();
        foreach($products as $p){
            $p_carts = $p->shoppingBags;
            if($p_carts->count() > 0){
                $the_carts = [];
                foreach ($p_carts as $c) {
                    $the_carts[$c->user->id] = ['user' => $c->user, 'cart' => $c];
                }
                $carts[$p->id] = $the_carts;
            }
            else{
                $carts[$p->id] = null;
            }
        }
        dd($carts);
    }





}