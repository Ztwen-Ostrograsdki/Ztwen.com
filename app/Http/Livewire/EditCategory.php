<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class EditCategory extends Component
{
    protected $listeners = ['targetedCategory'];
    public $category;
    public $name;
    public $description;
    protected $rules = [
        'name' => 'required|string|unique:categories|between:5,50',
        'description' => 'required|string|between:10,255',
    ];

    public function render()
    {
        return view('livewire.edit-category');
    }

    public function create()
    {
        $user = Auth::user();
        if($user){
            if($this->validate()){
                $category = Category::create(
                    [
                        'name' => $this->name,
                        'description' => $this->description,
                    ]
                );
                if($category){
                    $this->reset('name', 'description');
                    $this->dispatchBrowserEvent('hide-form');
                    $this->dispatchBrowserEvent('FireAlert', ['title' => 'Mise à jour de la catégorie', 'message' => "La mise à jourde la catégorie s'est bien déroulée", 'type' => 'success']);
                }
                else{
                    $this->dispatchBrowserEvent('FireAlert', ['title' => 'Echec ', 'message' => "La mise à jourde la catégorie a échoué", 'type' => 'error']);
                }
            }
        }
        else{
            return redirect(route('login'));
        }
    }

}
