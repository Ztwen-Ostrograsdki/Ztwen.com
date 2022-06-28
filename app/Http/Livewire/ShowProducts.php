<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ShowProducts extends Component
{
    protected $listeners = [
        
    ];
    public $records = 6;
    public $targets = null;
    public $section = null;
    public $category = null;
    public $perPage;
    public $page;
    public $scroll = true;
    public $active_section;
    public $categorySelected = null;

    public function mount($page = null, $perPage = null) 
    {
        $this->page = $page ?? 1;
        $this->perPage = $perPage ?? 6;
    }



    public function render()
    {
        if($this->scroll){
            $products = Product::paginate($this->perPage, ['*'], null, $this->page);
            $products = $this->getSelectedSessionProducts();
            return view('livewire.show-products', compact('products'));
        }
        else{
            $products = Product::where('slug', 'like', '%' . $this->targets . '%')->orWhere('description', 'like', '%' . $this->targets . '%')->paginate($this->perPage, ['*'], null, $this->page);
            return view('livewire.show-products', compact('products'));
        }
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
        if($category){
            $products = Product::where('category_id', $category)->paginate($this->perPage, ['*'], null, $this->page);
        }
        else{
            $products = Product::paginate($this->perPage, ['*'], null, $this->page);
        }
        return $products;
    }

    public function lastPosted($category = null)
    {
        $products = [];
        if($category){
            $products = Product::orderBy('created_at', 'desc')->where('category_id', $category)->paginate($this->perPage, ['*'], null, $this->page);
        }
        else{
            $products = Product::orderBy('created_at', 'desc')->paginate($this->perPage, ['*'], null, $this->page);
        }
        return $products;
    }

    public function mostSeen($category)
    {
        $products = [];
        if($category){
            $products = Product::orderBy('seen', 'desc')->where('category_id', $category)->paginate($this->perPage, ['*'], null, $this->page);
        }
        else{
            $products = Product::orderBy('seen', 'desc')->paginate($this->perPage, ['*'], null, $this->page);

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

    public function likedThis($product_id)
    {
        if(Auth::user()){
            $user = User::find(auth()->user()->id);
        }
        else{
            return redirect(route('login'));
        }
        $product = Product::find($product_id);
        if($product && $user){
            if($user->__likedThis($product->id)){
                $this->dispatchBrowserEvent('Toast', ['type' => 'success', 'title' => 'LIKE',  'message' => "Vous avez liker l'article " . $product->getName()]);
            }
        }
        else{
            return abort(403, "Votre requête ne peut aboutir");
        }
    }

    

}
