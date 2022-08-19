<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CategoryProfil extends Component
{

    public $category_id;
    public $search;
    public $on_search = false;

    public function mount(string $slug)
    {
        $slug = request()->slug;
        if($slug){
            $name = str_replace('-', '-', $slug);
            if(Category::whereName($name)->firstOrFail()){
                $this->category_id = Category::whereName($name)->first()->id;
            }
        }
        else{
            return redirect()->route('categories');
        }
    }

    public function render()
    {
        $category = Category::find($this->category_id);
        if($this->search && mb_strlen($this->search) >= 3){
            $search = $this->search;
            $products = $this->getProducts($this->category_id, $search);
        }
        else{
            $products = $category->products;
        }

        return view('livewire.category-profil', compact('category', 'products'));
    }



    public function toggleSearchBar($action = 'hide')
    {
        if($action && $action == "hide"){
            $this->reset('on_search', 'search');
        }
        else{
            $this->on_search = true;
        }
    }



    public function editCategory()
    {
        $category = Category::find($this->category_id);
        if($category){
            $this->emit('targetedCategory', $category->id);
        }
    }

    public function updatedSearch($v)
    {
        $this->search = $v;
    }

    public function getProducts($category_id, $search)
    {
        $products_on_slug = Product::where('category_id', $category_id)->where('slug', 'like', '%' . $search . '%')->get();
        $products_on_desc = Product::where('category_id', $category_id)->where('description', 'like', '%' . $search . '%')->get();

        $products = $products_on_desc->merge($products_on_slug);
        return $products;
    }


    public function editCategoryGalery()
    {
        $this->emit('editCategoryGaleryEvent', $this->category_id);
    }

    public function addToCart($product_id)
    {
        $product = Product::find($product_id);
        if($product){
            $add = $product->__addToUserCart();
            if($add){
                $this->dispatchBrowserEvent('ToastDoNotClose', ['title' => 'Ajout réussi', 'message' => "L'article {$product->getName()} a été ajouté à votre panier avec succès!", 'type' => 'success']);
            }
            else{
                $this->dispatchBrowserEvent($product->livewire_product_alert_by_toast, $product->livewire_product_errors);
            }
        }
    }


    
    public function deleteFromCart($product_id)
    {
        $product = Product::find($product_id);
        if($product){
            $del = $product->__retrieveFromUserCart();
            if($del){
                $this->dispatchBrowserEvent('ToastDoNotClose', ['title' => 'Suppression réussie', 'message' => "L'article {$product->getName()} a été retiré de votre panier avec succès!", 'type' => 'success']);
            }
            else{
                $this->dispatchBrowserEvent($product->livewire_product_alert_by_toast, $product->livewire_product_errors);
            }
        }
        $this->getProduct();
    }


    public function likedThis($product_id)
    {
        $user = Auth::user();

        if($user){
            $p = Product::find($product_id);
            if($p){
                $user = User::find($user->id);
                $product = $p;
                if($user->__likedThis($product->id)){
                    $this->dispatchBrowserEvent('ToastDoNotClose', ['title' => 'LIKE', 'message' => "Vous avez liker l'article {$product->getName()} !", 'type' => 'success']);
                }
            }
            else{
                $this->dispatchBrowserEvent('ToastDoNotClose', ['title' => 'Article inconnue', 'message' => "L'article que vous tenter de liker est introuvable ou a été déjà retiré!", 'type' => 'warning']);
            }
        }
        else{
            $this->dispatchBrowserEvent('ToastDoNotClose', ['title' => 'Connexion requise', 'message' => "Veuillez vous connecter avant d'exécuter cette action!", 'type' => 'warning']);
        }
    }

}
