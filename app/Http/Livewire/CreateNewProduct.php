<?php

namespace App\Http\Livewire;

use App\Events\NewProductCreatedEvent;
use App\Models\User;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use App\Models\MyNotifications;
use Illuminate\Support\Facades\Auth;

class CreateNewProduct extends Component
{
    protected $listeners = ['createAProduct', 'createNewCategory'];
    public $product;
    public $slug;
    public $description;
    public $categories = [];
    public $price;
    public $total;
    public $reduction;
    public $category_id;
    protected $rules = [
        'slug' => 'required|string|unique:products|between:5,50',
        'description' => 'required|string|between:10,255',
        'price' => 'required|numeric',
        'total' => 'required|numeric',
        'reduction' => 'numeric|max:100',
        'category_id' => 'required|numeric',
    ];

    public function render()
    {
        return view('livewire.create-new-product');
    }


    public function mount()
    {
        $this->categories = Category::all();
    }

    public function create()
    {

        $user = Auth::user();
        if($user){
            $this->slug = str_replace(' ', '-', $this->slug);
            if($this->validate()){
                $product = Product::create(
                    [
                        'slug' => $this->slug,
                        'description' => $this->description,
                        'price' => $this->price,
                        'total' => $this->total,
                        'reduction' => $this->reduction,
                        'category_id' => $this->category_id,
                    ]
                );
                if($product){
                    $this->emit('newProductCreated');
                    $this->reset('slug', 'description', 'total', 'price', 'reduction', 'category_id');
                    $this->dispatchBrowserEvent('hide-form');
                    $this->dispatchBrowserEvent('FireAlert', ['title' => 'Ajout du nouvel article', 'message' => "La création de l'article s'est bien déroulée", 'type' => 'success']);
                    
                    $users = User::all()->except($user->id);
                    if($users->count() > 0){
                        foreach ($users as $u){
                            MyNotifications::create([
                                'content' => "Un nouvel article a été posté dans la catégorie => :) " . mb_strtoupper($product->category->name),
                                'user_id' => $u->id,
                                'target' => "Nouvel Article",
                                'target_id' => $product->id
                            ]);
                        }
                    }

                }
                else{
                    $this->dispatchBrowserEvent('FireAlert', ['title' => 'Echec ', 'message' => "La création de l'article a échoué", 'type' => 'error']);
                }
            }
        }
        else{
            return redirect(route('login'));
        }
    }

    public function newCategoryCreated($category)
    {
        $this->mount();
    }

    public function createNewCategory()
    {
        if(session()->has('categorySelectedID') && session('categorySelectedID') !== null){
            $this->category_id = session('categorySelectedID');
        }
    }

    public function createAProduct()
    {
        $this->categories = Category::all();
    }
}
