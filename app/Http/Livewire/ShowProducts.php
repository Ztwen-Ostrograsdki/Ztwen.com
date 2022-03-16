<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use App\Models\ShoppingBag;
use App\Models\SeenLikeProductSytem;
use Illuminate\Support\Facades\Auth;

class ShowProducts extends Component
{
    protected $listeners = ['productUpdated'];
    public $products = [];
    public $product;
    public $targetedProductSeens;
    public $targetedProduct;
    public $allProducts = [];
    public $allProductsComments = [];
    public $pages = [];
    public $active_page = 0;
    public $minPage = 0;
    public $maxPage = 5;
    public $perpage = 6;
    public $galery;

    public function mount()
    {
        $this->getProducts(); 
    }

    public function render()
    {
        return view('livewire.show-products');
    }

    public function booted()
    {
        $this->getProducts();
    }

    public function productUpdated($product_id)
    {
        $this->getProducts(); 
    }

    public function setTargetedProduct($product_id)
    {
        $this->emit('resetTargetedProduct');
        $product = Product::find($product_id);
        if($product){
            $this->product = $product;
            $this->emit('targetedProduct', $product_id);
            $this->getProducts();
        }
        else{
            return abort(403, "Votre requête ne peut aboutir");
        }
    }

    public function getProducts()
    {

        $allProducts = Product::all()->chunk($this->perpage);
        $totalPages = count($allProducts);

        if($this->pages == []){
            for ($i = 0; $i < $totalPages; $i++) { 
                $this->pages[] = $i;
            }
     
        }
        $this->products = $allProducts[$this->active_page];
        foreach($this->products as $p){
            $this->allProductsComments[$p->id] = $p->comments;
        }
        
    }

    public function setActivePage($page)
    {
        $this->reset('allProductsComments');
        $this->reset('active_page');
        $this->reset('pages');
        $this->active_page = $page;
        $this->getProducts();
    }

    public function decreasePage()
    {  
        if($this){
            if($this->minPage - 1 == 0){
                $this->minPage = 0;
            }
            else{
                $this->minPage = $this->minPage - 1;
            }
            $this->maxPage = $this->maxPage - 1;
        }
    }
    public function increasePage()
    {
        if($this){
            if($this->maxPage + 1 == count($this->pages) - 1){
                $this->maxPage = count($this->pages) - 1;
            }
            else{
                $this->maxPage = $this->maxPage + 1;
            }
            $this->minPage = $this->minPage + 1;
        }
    }


    public function liked($product_id)
    {
        $user = Auth::user();
        $product = Product::find($product_id);

        if($product){
            $seen = $product->seen;
            if($user){
                $product->update(['seen' => $seen + 1]);
                SeenLikeProductSytem::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'reaction' => true,
                ]);
            }
            else{
                $product->update(['seen' => $seen + 1]);
                SeenLikeProductSytem::create([
                    'product_id' => $product->id,
                    'reaction' => true,
                ]);
            }
            $this->refreshData($product->id);
            // $this->emit('productUpdated', $product->id);
        }
        else{
            return abort(403, "Votre requête ne peut aboutir");
        }
    }

    public function refreshData($product_id)
    {
        $product = Product::find($product_id);
        if($product){
            $this->targetedProduct = $product;
            $this->targetedProductSeens = $product->seen;
        }
    }
    public function addToCart($product_id)
    {
        $user = Auth::user();

        if($user){
            $product = Product::find($product_id);
            if($product && !$user->alreadyIntoCart($product->id)){
                $panier = ShoppingBag::create(['user_id' => $user->id, 'product_id' => $product->id]);
                $this->emit('cartEdited', $user->id);
                $this->dispatchBrowserEvent('FireAlert', ['title' => false, 'message' => "vous avez ajouté l'article {$product->getName()} à votre panier", 'type' => 'success']);
            }
            else{
                return abort(403, "Votre requête ne peut aboutir");
            }

        }
        else{
            return redirect(route('login'));
        }
    }
    public function deleteFromCart($product_id)
    {
        $user = Auth::user();
        if($user){
            $product = Product::find($product_id);
            if($product && $user->alreadyIntoCart($product->id)){
                $shop = ShoppingBag::where('user_id', $user->id)->where('product_id', $product->id);
                if($shop->get()->count() > 0){
                    $action  = $shop->first()->delete();
                    if($action){
                        $this->emit('cartEdited', $user->id);
                        $this->dispatchBrowserEvent('FireAlert', ['title' => false, 'message' => "L'article {$product->getName()} a été retiré de votre panier", 'type' => 'success']);
                    }
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
