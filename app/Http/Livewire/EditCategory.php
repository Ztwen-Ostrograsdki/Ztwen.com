<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\Category;
use App\Models\MyNotifications;
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
        if($this->authenticated()){
            if($this->validate()){
                $cat = Category::withTrashed('deleted_at')->whereId($this->category->id)->firstOrFail();
                $validateName = Category::withTrashed('deleted_at')->whereName($this->name)->pluck('id')->first();
                if($validateName){
                    if($validateName == $this->category->id){
                        $updated = $this->category->update([
                            'description' => $this->description,
                        ]);
                        if($updated){
                            $this->reset('name', 'description');
                            $this->emit('categoriesUpdated');
                            $this->dispatchBrowserEvent('hide-form');
                            $this->dispatchBrowserEvent('FireAlert', ['title' => "Mise à jour d'une catégorie", 'message' => "La mise à jour de la catégorie s'est bien déroulée", 'type' => 'success']);
                            
                            $users = User::all()->except(Auth::user()->id);
                            if($users->count() > 0 && !$this->category->deleted_at){
                                foreach ($users as $u){
                                    MyNotifications::create([
                                        'content' => "Du NOUVEAU sur Ztwen.Com. La catégorie "  . mb_strtoupper($this->category->name) . " a été éditée :) ",
                                        'user_id' => $u->id,
                                        'target' => "Catégorie Editée",
                                        'target_id' =>$this->category->id
                                    ]);
                                }
                            }
                        }
                    }
                    else{
                        $this->addError('name', "Ce nom est déja existent!");
                    }
                }
                else{
                    $updated = $this->category->update([
                        'name' => $this->name,
                        'description' => $this->description,
                    ]);
                    if($updated){
                        $new  = Category::withTrashed('deleted_at')->whereId($this->category->id)->firstOrFail();
                        $this->reset('name', 'description');
                        $this->emit('categoriesUpdated');
                        $this->dispatchBrowserEvent('hide-form');
                        $this->dispatchBrowserEvent('FireAlert', ['title' => "Mise à jour d'une catégorie", 'message' => "La mise à jour de la catégorie s'est bien déroulée", 'type' => 'success']);

                        $users = User::all()->except(Auth::user()->id);
                        if($users->count() > 0 && !$this->category->deleted_at){
                            foreach ($users as $u){
                                MyNotifications::create([
                                    'content' => "Du NOUVEAU sur Ztwen.Com. La catégorie "  . mb_strtoupper($cat->name) . " a été éditée. Elle est désormais nommée " . mb_strtoupper($new->name) . ":) ",
                                    'user_id' => $u->id,
                                    'target' => "Catégorie Editée",
                                    'target_id' => $this->category->id
                                ]);
                            }
                        }
                            
                    }
                }
            }
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

    public function authenticated()
    {
        if(Auth::user()){
            if(User::find(Auth::user()->id)->__hasAdminAuthorization()){
                return true;
            }
            else{
                return $this->dispatchBrowserEvent('FireAlertDoNotClose', ['title' => 'Authentification requise', 'message' => "Veuillez vous authentifier avant de d'exécuter cette action!", 'type' => 'warning']);
            }
        }
        else{
            return redirect()->route('login');
        }
    }

}
