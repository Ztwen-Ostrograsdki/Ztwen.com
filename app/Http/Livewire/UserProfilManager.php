<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ZtwenManagers\ZtwenImageManager;

class UserProfilManager extends Component
{
    public $user;
    public $user_profil;
    protected $listeners = [];

    use WithFileUploads;

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function render()
    {
        return view('livewire.user-profil-manager');
    }

    public function updateUserProfilPhoto()
    {
        $this->validate(['user_profil' => 'image|max:3000|mimes:png,jpg,jpeg']);
        $make = (new ZtwenImageManager($this->user, $this->user_profil))->storer($this->user->imagesFolder);
        if ($make) {
            $this->dispatchBrowserEvent('hide-form');
            $this->dispatchBrowserEvent('FireAlert', ['title' => 'Mise à jour réussie', 'message' => "La mise à jour de votre profil s'est bien déroulée", 'type' => 'success']);
            $this->emit("userProfilUpdate", $this->user->id);
        }
        else{
            $this->dispatchBrowserEvent('FireAlert', ['title' => 'Ereur serveur', 'message' => "La mise à jour de votre profil a échoué, veuillez réessayer!", 'type' => 'error']);
        }
        
    }

}
