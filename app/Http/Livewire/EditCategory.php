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
        'description' => 'required|string|between:10,255',
    ];

    public function render()
    {
        return view('livewire.edit-category');
    }

    public function update()
    {
        $user = Auth::user();
        if($user && ($user->role == 'admin' || $user->id == 1)){
            if($this->validate()){
                $validateName = Category::withTrashed('deleted_at')->whereName($this->name)->pluck('id')->first();
                if($validateName){
                    if($validateName == $this->category->id){
                        $upadte = $this->category->update([
                            'description' => $this->description,
                        ]);
                        if($upadte){
                            $this->reset('name', 'description');
                            $this->emit('categoriesUpdated');
                            $this->dispatchBrowserEvent('hide-form');
                            $this->dispatchBrowserEvent('FireAlert', ['title' => 'Mise à jour de la catégorie', 'message' => "La mise à jourde la catégorie s'est bien déroulée", 'type' => 'success']);
                        }
                    }
                    else{
                        $this->addError('name', "Ce nom est déja existent!");
                    }
                }
                else{
                    $upadte = $this->category->update([
                        'name' => $this->name,
                        'description' => $this->description,
                    ]);
                    if($upadte){
                        $this->reset('name', 'description');
                        $this->emit('categoriesUpdated');
                        $this->dispatchBrowserEvent('hide-form');
                        $this->dispatchBrowserEvent('FireAlert', ['title' => 'Mise à jour de la catégorie', 'message' => "La mise à jourde la catégorie s'est bien déroulée", 'type' => 'success']);
                    }
                }
            }
        }
        else{
            return redirect(route('login'));
        }
    }

    public function targetedCategory($category)
    {
        $category = Category::withTrashed('deleted_at')->whereId($category)->firstOrFail();
        if($category){
            $this->category = $category;
            $this->name = $category->name;
            $this->description = $category->description;
            $this->dispatchBrowserEvent('modal-editCategory');
        }
        else{
            return abort(403, "Votre requête ne peut aboutir");
        }
    }

}
