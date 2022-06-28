<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class ProductsHome extends Component
{
    protected $listeners = [
        
    ];
    public $active_section;
    public $products_targeted = [];
    public $records = 6;
    public $categorySelected = null;
    public $target = null;
    public $searching = false;
    public $changer = false;
    


    public $perPage;
    public $page;

    public function mount($page = null, $perPage = null) 
    {
        $this->page = $page ?? 1;
        $this->perPage = $perPage ?? 6;

        if(session()->has('sectionSelected') && session('sectionSelected')){
            $this->active_section = session('sectionSelected');
        }
        else{
            $this->active_section = 'allPosted';
        }
        if(session()->has('categorySelected') && session('categorySelected')){
            $this->categorySelected = session('categorySelected');
        }
    }

    public function render()
    {
        $categories = Category::all();
        $products_records = Product::all()->count();
        $categories = Category::all();

        return view('livewire.products-home', [
            'categories' => $categories,
            'products_records' => $products_records,
        ]);
    }

    public function updatedTarget($value)
    {
        if($value && mb_strlen($value) > 3){
            $this->searching = true;
        }
        else{
            $this->reset('searching');
        }
    }

    public function productUpdated($product_id)
    {
        $this->getProducts($this->active_section); 
    }


    public function changeCategory()
    {
        $this->changer = !$this->changer;
        session()->put('categorySelected', (int)$this->categorySelected);
    }

    public function changeSection(string $section)
    {
        session()->put('sectionSelected', $this->active_section);
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
