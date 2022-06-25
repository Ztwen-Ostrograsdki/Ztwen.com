<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

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
    public $galery;
    public $categorySelectedID;
    public $category_id;

    public function mount()
    {
        $id = (int)request()->id;
        if($id){
            if(Category::find($id)){
                $this->category_id = $id;
            }
            else{
                return abort(403, "Votre requête ne peut aboutir");
            }
        }
    }

    public function render()
    {
        $category = null;
        $categories = Category::orderBy('name', 'asc')->get();
        $user = Auth::user();
        $productsCounter = Product::all()->count();
        if($this->category_id){
            $category = Category::find($this->category_id);
        }
        $this->setCategory($this->category_id, false);
        return view('livewire.show-categories', compact('categories', 'productsCounter', 'category'));
    }

    public function categorySelected($category_id)
    {
        $this->setCategory($category_id);
    }
    
    public function changeCategory($category_id = null)
    {
        $this->reset('search', 'targets');
        session()->forget('categorySelectedID');
        if($category_id !== null){
            $this->setCategory($category_id); 
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
            $this->setCategory($this->category_id, false);
        }
    }

    public function setCategory($category_id = null, $reset_search = true)
    {
        $products = [];
        if($reset_search){
            $this->reset('search', 'targets');
        }
        if($category_id){
            $this->category_id = $category_id;
            $category = Category::find($category_id);
            $this->categorySelectedID = $category_id;
            session()->put('categorySelectedID', $category_id);
        }
        elseif(session()->has('categorySelectedID') && session('categorySelectedID') !== null){
            $this->categorySelectedID = session('categorySelectedID');
            $category = Category::find($this->categorySelectedID);
            $category_id = $category->id;
        }
        else{
            session()->forget('categorySelectedID');
        }

        return $products;
    }

    public function addToCart($product_id = null)
    {
        if(!$product_id){
            $product = null;
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
                $this->emit('myCartWasUpdated', Auth::user()->id);
                $this->dispatchBrowserEvent('FireAlertDoNotClose', ['title' => 'Ajout réussi', 'message' => "L'article {$product->getName()} a été ajouté à votre panier avec succès!", 'type' => 'success']);
            }
            else{
                $this->dispatchBrowserEvent($product->livewire_product_alert_type, $product->livewire_product_errors);
            }
        }
    }
    
    public function deleteFromCart($product_id = null)
    {
        if(!$product_id){
            $product = null;
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
                $this->emit('myCartWasUpdated', Auth::user()->id);
                $this->dispatchBrowserEvent('FireAlertDoNotClose', ['title' => 'Suppression réussie', 'message' => "L'article {$product->getName()} a été retiré de votre panier avec succès!", 'type' => 'success']);
            }
            else{
                $this->dispatchBrowserEvent($product->livewire_product_alert_type, $product->livewire_product_errors);
            }
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
        $user = User::find(auth()->user()->id);
        if($product && $user){
            $user->likedThis('product', $product->id, $user->id);
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
