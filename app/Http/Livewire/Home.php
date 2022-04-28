<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;

class Home extends Component
{
    protected $listeners = ['productUpdated'];
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
        $this->lastComments = Comment::where('blocked', 0)->where('approved', 1)->take(3)->get();
        $this->lastComments = Comment::all()->take(3);
        $this->lastPosted(); 
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


}
