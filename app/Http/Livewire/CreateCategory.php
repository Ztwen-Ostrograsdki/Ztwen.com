<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\Category;
use App\Models\MyNotifications;
use Illuminate\Support\Facades\Auth;

class CreateCategory extends Component
{
    public $category;
    public $name;
    public $description;
    protected $rules = [
        'name' => 'required|string|unique:categories|between:5,50',
        'description' => 'required|string|between:10,255',
    ];

    public function render()
    {
        return view('livewire.create-category');
    }

    public function create()
    {
        $user = Auth::user();
        if($user && ($user->role == 'admin' || $user->id == 1)){
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
                    $this->dispatchBrowserEvent('FireAlert', ['title' => 'Ajout de nouvelle catégorie', 'message' => "La création de la catégorie s'est bien déroulée", 'type' => 'success']);
                    $this->emit('newCategoryCreated', $category);
                    
                    $users = User::all()->except($user->id);
                    if($users->count() > 0){
                        foreach ($users as $u){
                            MyNotifications::create([
                                'content' => "BOUMMMMMM!!!!!! Du NOUVEAUTEEEEE sur Ztwen.Com. La catégorie "  . mb_strtoupper($category->name) . " est désormais disponible sur la plateforme :) ",
                                'user_id' => $u->id,
                                'target' => "Nouvelle Catégorie",
                                'target_id' => $category->id
                            ]);
                        }
                    }
                }
                else{
                    $this->dispatchBrowserEvent('FireAlert', ['title' => 'Echec ', 'message' => "La création de la catégorie a échoué", 'type' => 'error']);
                }
            }
        }
        else{
            return redirect(route('login'));
        }
    }



}
