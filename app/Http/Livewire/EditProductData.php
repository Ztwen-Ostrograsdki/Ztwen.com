<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class EditProductData extends Component
{
    protected $listeners = ['editAProduct'];
    public $product;
    public $categories;
    public $slug;
    public $description;
    public $price;
    public $total;
    public $reduction;
    public $category_id;
    protected $rules = [
        'slug' => 'required|string|between:5,50',
        'description' => 'required|string|between:10,255',
        'price' => 'required|numeric',
        'total' => 'required|numeric',
        'reduction' => 'numeric|max:100',
        'category_id' => 'required|numeric',
    ];

    public function mount()
    {
        $this->categories = Category::withTrashed('deleted_at')->get();
    }

    public function render()
    {
        return view('livewire.edit-product-data');
    }

    public function editAProduct($product_id)
    {
        $product  = Product::withTrashed('deleted_at')->whereId($product_id)->firstOrFail();
        if($product){
            $this->product = $product;
            $this->slug = $this->product->slug;
            $this->description = $this->product->description;
            $this->price = $this->product->price;
            $this->total = $this->product->total;
            $this->reduction = $this->product->reduction;
            $this->category_id = $this->product->category_id;
        }
    }



    public function updateData()
    {
        if($this->authenticated()){
            $product  = Product::withTrashed('deleted_at')->whereId($this->product->id)->first();
            if($product){
                $this->slug = str_replace(' ', '-', $this->slug);
                if($this->validate()){
                    $product->update(
                        [
                            'slug' => $this->slug,
                            'description' => $this->description,
                            'price' => $this->price,
                            'total' => $this->total,
                            'reduction' => $this->reduction,
                            'category_id' => $this->category_id,
                        ]
                    );
                    $this->dispatchBrowserEvent('hide-form');
                    $this->emit('productUpdated', $product->id);
                    $this->dispatchBrowserEvent('FireAlert', ['title' => 'Mise à jour réussie', 'message' => "La mise à jour de l'article s'est bien déroulée", 'type' => 'success']);
                }
            }
            else{
                return abort(403, "Votre requête ne peut aboutir");
            }
        }

    }

    public function authenticated()
    {
        if(Auth::user()){
            if(User::find(Auth::user()->id)->__hasAdminAuthorization()){
                return true;
            }
            else{
                return $this->dispatchBrowserEvent('FireAlertDoNotClose', ['title' => 'Authentification requise', 'message' => "Veuillez vous enthentifier avant de lancer des mises à jour", 'type' => 'warning']);
            }
        }
        else{
            return redirect()->route('login');
        }
    }

    
}
