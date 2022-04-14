<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use App\Models\ShoppingBag;
use App\Models\SeenLikeProductSytem;
use Illuminate\Support\Facades\Auth;

class ShowCategories extends Component
{
    protected $listeners = ['productUpdated', 'newCategoryCreated'];
    public $products = [];
    public $categorySelectedID;
    public $categories;
    public $category;
    public $allProducts = [];

    public function mount()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        $this->categories = $categories;
        $this->getProducts();
    }

    public function render()
    {
        return view('livewire.show-categories');
    }
    
    public function changeCategory($category_id = null)
    {
        session()->forget('categorySelectedID');
        if($category_id !== null){
            session()->put('categorySelectedID', $category_id);
            $this->getProducts($category_id); 
        }
       else{
            session()->forget('categorySelected');
       }
    }

    public function getProducts($category_id = null)
    {
        $this->reset('products');
        if($category_id){
            $this->category = Category::find($category_id);
            $this->categorySelectedID = $category_id;
            $this->products = $this->category->products;
        }
        elseif(session()->has('categorySelectedID') && session('categorySelectedID') !== null){
            $this->categorySelectedID = session('categorySelectedID');
            $this->category = Category::find($this->categorySelectedID);
            $this->products = $this->category->products;
        }
        else{
            session()->forget('categorySelectedID');
            $this->products = [];
        }
    }

    public function newCategoryCreated()
    {
        $this->mount();
    }

    
    
    
}
