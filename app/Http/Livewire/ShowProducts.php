<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class ShowProducts extends Component
{
    protected $listeners = [
        'productUpdated', 
        'newCategoryCreated',
        'aProductHasBeenDeleted', 'aProductHasBeenRestored', 
        'aCategoryHasBeenDeleted', 'aCategoryHasBeenRestored'
    ];
    public $products = [];
    public $product;
    public $targetedProductSeens;
    public $categorySelected = null;
    public $categorySelected_id;
    public $categories;
    public $targetedProduct;
    public $allProducts = [];
    public $allProductsComments = [];
    public $pages = [];
    public $active_page = 0;
    public $minPage = 0;
    public $maxPage = 5;
    public $perpage = 6;
    public $galery;
    public $user;


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
            $product->update(['seen' => $product->seen + 1]);
        }
        else{
            return abort(403, "Votre requête ne peut aboutir");
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

    public function getProducts($all = [], $products = [])
    {
        $this->reset('pages', 'products', 'allProducts', 'active_page');
        $this->categories = Category::all();
        if($all !== []){
            $this->allProducts = $all;
            if(count($all) > 0){
                $totalPages = count($products);
                for ($i = 0; $i < $totalPages; $i++) { 
                    $this->pages[] = $i;
                }
                $this->products = $products[$this->active_page];
                foreach($this->products as $p){
                    $this->allProductsComments[$p->id] = $p->comments;
                }
            }
            
        }
        else{
            if(session()->has('categorySelected')){
                $this->categorySelected = session('categorySelected');
                $this->changeEvent();
            }
            elseif(session()->has('sectionSelected') && session('sectionSelected') !== 'allPosted'){
                session()->forget('categorySelected');
                $section = session('sectionSelected');
                $this->changeSection($section);
            }
            else{
                $this->allProducts = Product::all();
                session()->put('sectionSelected', 'allPosted');
                if(Product::all()->count() > 0){
                    $allProducts = Product::all()->reverse()->chunk($this->perpage);
                    $totalPages = count($allProducts);
        
                    for ($i = 0; $i < $totalPages; $i++) { 
                        $this->pages[] = $i;
                    }
                    $this->products = $allProducts[$this->active_page];
                    foreach($this->products as $p){
                        $this->allProductsComments[$p->id] = $p->comments;
                    }
                }
            }
            
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
        if(Auth::user()){
            $this->user = Auth::user();
        }
        else{
            return redirect(route('login'));
        }
        $product = Product::find($product_id);
        if($product && $this->user){
            if($this->user->addToCart($product->id)){
                $this->dispatchBrowserEvent('FireAlert', ['title' => 'Réussie', 'message' => "vous avez ajouté l'article {$product->getName()} à votre panier", 'type' => 'success']);
                $this->emit('cartEdited', $this->user->id);
            }
            else{
                return abort(403, "Votre requête ne peut aboutir");
            }
        }
    }



    public function deleteFromCart($product_id)
    {
        if(Auth::user()){
            $this->user = Auth::user();
        }
        else{
            return redirect(route('login'));
        }
        $product = Product::find($product_id);
        if($product && $this->user){
            if($this->user->deleteFromCart($product->id)){
                $this->emit('cartEdited', $this->user->id);
                $this->dispatchBrowserEvent('FireAlert', ['title' => 'Réussie', 'message' => "L'article {$product->getName()} a été retiré de votre panier", 'type' => 'success']);
            }
            else{
                return abort(403, "Votre requête ne peut aboutir");
            }
        }
    }



    public function updategalery($product_id)
    {
        $product = Product::find($product_id);
        if($product){
            $this->emit('targetedProduct', $product->id);
            $this->dispatchBrowserEvent('modal-updateProductGalery');
        }
    }

    public function editAProduct($product_id)
    {
        $product = Product::find($product_id);
        if($product){
            $this->emit('editAProduct', $product->id);
            $this->dispatchBrowserEvent('modal-editProduct');
        }
    }

    public function liked($product_id)
    {
        if(Auth::user()){
            $this->user = Auth::user();
        }
        else{
            return redirect(route('login'));
        }
        $product = Product::find($product_id);
        if($product && $this->user){
            if($this->user->likedThis('product', $product->id, $this->user->id)){
                $this->refreshData($product->id);
            }
        }
        else{
            return abort(403, "Votre requête ne peut aboutir");
        }
    }

    public function aProductHasBeenDeleted($product_id)
    {
        $this->booted();
    }
    public function aProductHasBeenRestored($product_id)
    {
        $this->booted();
    }
    public function newCategoryCreated($category)
    {
        $this->getProducts();
    }
    public function aCategoryHasBeenRestored($category)
    {
        $this->booted();
    }
    public function aCategoryHasBeenDeleted($category)
    {
        $this->booted();
    }

}
