<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use App\Models\SeenLikeProductSytem;
use Illuminate\Support\Facades\Auth;

class ShowProducts extends Component
{

    public $products = [];
    public $product;
    public $allProducts = [];
    public $allProductsComments = [];
    public $name = "composant ";
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
        if($this->minPage - 1 == 0){
            $this->minPage = 0;
        }
        else{
            $this->minPage = $this->minPage - 1;
        }
        $this->maxPage = $this->maxPage - 1;
    }
    public function increasePage()
    {
        if($this->maxPage + 1 == count($this->pages) - 1){
            $this->maxPage = count($this->pages) - 1;
        }
        else{
            $this->maxPage = $this->maxPage + 1;
        }
        $this->minPage = $this->minPage + 1;
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
        }
        else{
            return abort(403, "Votre requête ne peut aboutir");
        }
    }







}
