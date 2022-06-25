<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class ShowProducts extends Component
{
    use WithPagination;

    protected $listeners = [
        'productUpdated', 
        'newCategoryCreated',
        'aProductHasBeenDeleted', 'aProductHasBeenRestored', 
        'aCategoryHasBeenDeleted', 'aCategoryHasBeenRestored'
    ];
    public $active_section;
    public $categorySelected = null;
    public $target = null;


    public function getProductsBySearch($v)
    {
        $searchTerm = '%'.$v.'%';
        $data1 = Product::where('slug','like', $searchTerm)->orWhere('description','like', $searchTerm);
        
        $categories = Category::where('name','like', $searchTerm)->orWhere('description','like', $searchTerm);
        $data2 = [];
        if($categories->get()->count() > 0){
            foreach($categories as $category){
                $data2[] = $category->products;
            }
        }

        return $data1->get()->count() > 0 ? $data1->paginate(6) : ($categories->get()->count() > 0 ? $data2 : []);
    }


    public function render()
    {
        $categories = Category::all();
        $products = $this->getProducts();
        return view('livewire.show-products', compact('products', 'categories'));
    }


    public function productUpdated($product_id)
    {
        $this->getProducts($this->active_section); 
    }


    public function changeCategory()
    {
        session()->put('categorySelected', $this->categorySelected);
        $this->getProducts();
    }
    public function changeSection(string $section)
    {
        $this->active_section = $section;
        session()->put('sectionSelected', $this->active_section);
    }

    
    public function getProducts()
    {
        if($this->target && strlen($this->target) > 3){
            return $this->getProductsBySearch($this->target);
        }
        return $this->getSelectedSessionProducts();
    }


    public function getSelectedSessionProducts()
    {
        if(session()->has('sectionSelected') && session('sectionSelected')){
            $this->active_section = session('sectionSelected');
        }
        else{
            $this->active_section = 'allPosted';
        }
        if(session()->has('categorySelected') && session('categorySelected')){
            $this->categorySelected = session('categorySelected');
        }

        $section = $this->active_section;
        $category = $this->categorySelected;
        if($section == 'lastPosted'){
            return $this->lastPosted($category);
        }
        elseif($section == 'mostSeen'){
            return $this->mostSeen($category);
        }
        else{
            return $this->allPosts($category);
        }
        
    }

    public function allPosts($category = null)
    {
        $products = [];
        if(session('sectionSelected')){
            if($category){
                $products = Product::where('category_id', $category)->paginate(6);
            }
            else{
                $products = Product::paginate(6);
            }
        }
        return $products;
    }

    public function lastPosted($category = null)
    {
        $products = [];
        if(session('sectionSelected')){
            if($category){
                $products = Product::orderBy('created_at', 'desc')->where('category_id', $category)->paginate(6);
            }
            else{
                $products = Product::orderBy('created_at', 'desc')->paginate(6);
            }
        }
        return $products;
    }

    public function mostSeen($category)
    {
        $products = [];
        if(session('sectionSelected')){
            if($category){
                $products = Product::orderBy('seen', 'desc')->where('category_id', $category)->paginate(6);
            }
            else{
                $products = Product::orderBy('seen', 'desc')->paginate(6);
            }
        }
        return $products;
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
        $this->getProducts();
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
            $user = User::find(auth()->user()->id);
        }
        else{
            return redirect(route('login'));
        }
        $product = Product::find($product_id);
        if($product && $user){
            if($user->likedThis('product', $product->id, $user->id)){
                $this->refreshData($product->id);
            }
        }
        else{
            return abort(403, "Votre requête ne peut aboutir");
        }
    }

    public function aProductHasBeenDeleted($product_id)
    {
    }
    public function aProductHasBeenRestored($product_id)
    {
    }
    public function newCategoryCreated($category)
    {
    }
    public function aCategoryHasBeenRestored($category)
    {
    }
    public function aCategoryHasBeenDeleted($category)
    {
    }

}
