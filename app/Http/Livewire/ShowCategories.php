<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isInstanceOf;

class ShowCategories extends Component
{
    protected $listeners = [
        'productUpdated', 'categoriesUpdated',
        'newCategoryCreated', 'newProductCreated', 
        'connected', 
        'categorySelected', 
        'aProductHasBeenDeleted', 'aProductHasBeenRestored', 
        'aCategoryHasBeenDeleted', 'aCategoryHasBeenRestored'
    ];
    public $search;
    public $targets = [];
    public $products = [];
    public $productsCounter;
    public $galery;
    public $categorySelectedID;
    public $categories;
    public $category;
    public $user;
    public $allProducts = [];

    public function mount()
    {
        $id = (int)request()->id;
        if($id){
            $category = Category::find($id);
            if($category){
                $this->getProducts($id);
            }
            else{
                return abort(403, "Votre requête ne peut aboutir");
            }
        }

        $categories = Category::orderBy('name', 'asc')->get();
        $this->user = Auth::user();
        $this->categories = $categories;
        $this->productsCounter = Product::all()->count();
        $this->getProducts();
    }

    public function render()
    {
        return view('livewire.show-categories');
    }

    public function categorySelected($category_id)
    {
        $this->changeCategory($category_id);
    }
    
    public function changeCategory($category_id = null)
    {
        $this->reset('search', 'targets');
        session()->forget('categorySelectedID');
        if($category_id !== null){
            session()->put('categorySelectedID', $category_id);
            $this->getProducts($category_id); 
        }
        else{
            session()->forget('categorySelectedID');
        }
    }

    public function updatedSearch($v)
    {
        $this->targets['products'] = [];
        $this->targets['categories'] = [];
        if($v && strlen($v) >= 3){
            $searchTerm = '%'. $v .'%';
            $targets1 = Product::orderBy('slug', 'asc')->where('slug','like', $searchTerm)->orWhere('description','like', $searchTerm)->get();
            $targets2 = Category::orderBy('name', 'asc')->where('name','like', $searchTerm)->orWhere('description','like', $searchTerm)->get();
            
            if($targets1->count() > 0){
                $this->targets['products'] = $targets1;
            }
            if($targets2->count() > 0){
                $this->targets['categories'] = $targets2;
            }
            
        }
        else{
            $this->mount();
        }
    }

    public function getProducts($category_id = null)
    {
        $this->reset('products');
        if($category_id){
            $this->category = Category::find($category_id);
            $this->categorySelectedID = $category_id;
            session()->put('categorySelectedID', $category_id);
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

    public function createNewCategory()
    {
        $this->emit('createNewCategory');
    }

    public function newCategoryCreated()
    {
        $this->mount();
    }
    public function aCategoryHasBeenRestored($category_id)
    {
        $this->mount();
    }
    public function aCategoryHasBeenDeleted($category_id)
    {
        $this->mount();
    }
    public function aProductHasBeenDeleted($product_id)
    {
        $this->mount();
    }
    public function aProductHasBeenRestored($product_id)
    {
        $this->mount();
    }
    public function newProductCreated()
    {
        $this->mount();
    }
    public function categoriesUpdated()
    {
        $this->mount();
    }

    public function bought($product_id)
    {

    }
    
    public function addToCart($product_id)
    {
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

    public function editACategory($category_id)
    {
        $category = Category::find($category_id);
        if($category){
            $this->emit('targetedCategory', $category->id);
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
        $product = Product::find($product_id);
        if($product && $this->user){
            if($this->user->likedThis('product', $product->id, $this->user->id)){
                $this->mount();
            }
        }
        else{
            return abort(403, "Votre requête ne peut aboutir");
        }
    }




    public function connected($user_id)
    {
        if(Auth::user() && Auth::user()->id == $user_id){
            $this->mount();
        }
    }


    
    
    
}
