<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Helpers\ZtwenManagers\ZtwenImageManager;
use App\Models\Category;

class ManageCategoryGalery extends Component
{

    use WithFileUploads;
    public $category;
    public $category_image;
    protected $listeners = ['editCategoryGaleryEvent'];

    public function render()
    {
        return view('livewire.manage-category-galery');
    }


    public function update()
    {
        $this->validate(['category_image' => 'image|max:3000|mimes:png,jpg,jpeg']);
        $make = (new ZtwenImageManager($this->category, $this->category_image))->storer($this->category->imagesFolder);
        if ($make) {
            $this->dispatchBrowserEvent('hide-form');
            $this->dispatchBrowserEvent('FireAlert', ['title' => 'Mise à jour réussie', 'message' => "La galerie de la catégorie {{$this->category->name}} a été mis à jour avec succès", 'type' => 'success']);
        }
        else{
            $this->dispatchBrowserEvent('FireAlert', ['title' => 'Ereur serveur', 'message' => "La mise à jour de la galerie a échoué, veuillez réessayer!", 'type' => 'error']);
        }
        
    }


    public function editCategoryGaleryEvent($category_id)
    {
        $category = Category::find($category_id);
        if($category){
            $this->category = $category;
            $this->dispatchBrowserEvent('modal-updateCategoryGalery');
        }
        else{
            return abort(403);
        }
    }
}
