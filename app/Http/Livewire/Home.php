<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class Home extends Component
{
    protected $listeners = ['productUpdated', 'productsUpdated'];
    public $products = [];
    public $categories;
    public $targetedProduct;
    public $lastComments;
    public $allProducts = [];
    public $allProductsComments = [];
    public $perpage = 6;
    public $galery;
    public $active_page = 0;
    public $minPage = 0;
    public $maxPage = 5;
    public $pages = [];


    public function mount()
    {
        $this->lastComments = Comment::where('blocked', 0)->where('approved', 1)->orderBy('created_at', 'desc')->take(3)->get();
        $this->lastPosted(); 
    }

    public function productsUpdated()
    {
        $this->getProducts(); 
    }
    public function refreshThePosts()
    {
        $this->lastPosted(); 
    }
    public function refreshCommentsData()
    {
        $this->lastComments = Comment::where('blocked', 0)->where('approved', 1)->orderBy('created_at', 'desc')->take(3)->get();
    }

    public function render()
    {
        return view('livewire.home');

    }

    public function getProducts($all = [], $products = [])
    {
        $this->reset('pages', 'products', 'allProducts', 'active_page');
        $this->categories = Category::all();
        if($all !== []){
            $this->allProducts = $all;
            if(count($all) > 0){
                $this->products = $products[0];
                foreach($this->products as $p){
                    $this->allProductsComments[$p->id] = $p->comments;
                }
            }
            
        }
        else{
            $this->allProducts = Product::all();
            session()->put('sectionSelected', 'allPosted');
            if(Product::all()->count() > 0){
                $allProducts = Product::all()->reverse()->chunk($this->perpage);
                $totalPages = count($allProducts);
    
                $this->products = $allProducts[0];
                foreach($this->products as $p){
                    $this->allProductsComments[$p->id] = $p->comments;
                }
            }
            
        }
        
        
        
    }


    public function changeEvent()
    {
        $category = $this->categorySelected;
        if($category !== null && $category !== ""){
            session()->put('sectionSelected', 'allPosted');
            session()->put('categorySelected', $this->categorySelected);
            $this->categorySelected_id = Category::where('name', $this->categorySelected)->first()->id;
            $all = Product::where('category_id', $this->categorySelected_id)->get();
            $products = Product::where('category_id', $this->categorySelected_id)->get()->chunk($this->perpage);
            $this->getProducts($all, $products);
            
        }
        else{
            session()->forget('categorySelected');
            $this->getProducts();
        }

    }

    public function changeSection($section = 'allPosted')
    {
        session()->put('sectionSelected', $section);
        if($section == 'lastPosted'){
            $this->lastPosted();
        }
        elseif($section == 'mostSeen'){
            $this->mostSeen();
        }
        else{
            $this->getProducts();
        }
        
    }

    public function lastPosted($max = 6)
    {
        if(!$max){
            $max = $this->perpage;
        }
        else{
            $max = $max;
        }
        $all = Product::all()->reverse()->take($max);
        $products = $all->chunk($max);
        $this->reset('pages', 'products', 'allProducts', 'active_page');
        session()->forget('categorySelected');
        session()->put('sectionSelected', 'lastPosted');
        $this->getProducts($all, $products);
    }

    public function mostSeen($max = 6)
    {
        if(!$max){
            $max = $this->perpage;
        }
        else{
            $max = $max;
        }
        $all = Product::orderBy('seen', 'desc')->get()->take($max);
        $products = $all->chunk($max);
        $this->reset('pages', 'products', 'allProducts', 'active_page');
        session()->forget('categorySelected');
        session()->put('sectionSelected', 'mostSeen');
        $this->getProducts($all, $products);
    }


    public function loadProductImages($product_id)
    {
        $this->emit('loadProductImages', $product_id);
    }

    public function addToCart($product_id = null)
    {
        if(!$product_id){
            $product = $this->product;
        }
        else{
            $p = Product::find($product_id);
            if($p){
                $product = $p;
            }
            else{
                $this->dispatchBrowserEvent('FireAlertDoNotClose', ['title' => 'Article inconnue', 'message' => "L'article que vous tenter d'ajouter à votre panier est introuvable ou a été déjà retiré!", 'type' => 'warning']);
            }
        }
        if($product){
            $add = $product->__addToUserCart();
            if($add){
                $this->emit('productsUpdated');
                $this->emit('cartEdited', Auth::user()->id);
                $this->dispatchBrowserEvent('FireAlertDoNotClose', ['title' => 'Ajout réussi', 'message' => "L'article {$product->getName()} a été ajouté à votre panier avec succès!", 'type' => 'success']);
            }
            else{
                $this->dispatchBrowserEvent($product->livewire_product_alert_type, $product->livewire_product_errors);
            }
        }

        $this->emit('productsUpdated');

    }
    
    public function deleteFromCart($product_id = null)
    {
        if(!$product_id){
            $product = $this->product;
        }
        else{
            $p = Product::find($product_id);
            if($p){
                $product = $p;
            }
            else{
                $this->dispatchBrowserEvent('FireAlertDoNotClose', ['title' => 'Article inconnue', 'message' => "L'article que vous tenter d'ajouter à votre panier est introuvable ou a été déjà retiré!", 'type' => 'warning']);
            }
        }
        if($product){
            $del = $product->__retrieveFromUserCart();
            if($del){
                $this->emit('productsUpdated');
                $this->emit('cartEdited', Auth::user()->id);
                $this->dispatchBrowserEvent('FireAlertDoNotClose', ['title' => 'Suppression réussie', 'message' => "L'article {$product->getName()} a été retiré de votre panier avec succès!", 'type' => 'success']);
            }
            else{
                $this->dispatchBrowserEvent($product->livewire_product_alert_type, $product->livewire_product_errors);
            }
        }

        $this->emit('productsUpdated');
    }


    


}
