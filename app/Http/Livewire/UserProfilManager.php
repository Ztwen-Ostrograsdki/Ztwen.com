<?php

namespace App\Http\Livewire;

use App\Models\Photo;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserProfilManager extends Component
{
    public $user;
    public $user_profil;
    public $photoExtension;
    public $photoName;
    protected $listeners = ['userProfilUpdate'];

    use WithFileUploads;

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function render()
    {
        return view('livewire.user-profil-manager');
    }

    public function editUserProfilPhoto()
    {
        $this->validate(['user_profil' => 'image|max:3000|mimes:png,jpg,jpeg']);
        $this->photoExtension = $this->user_profil->extension();
        $this->setImageName($this->photoExtension);
        $this->user_profil->storeAs('profilPhotos', $this->getImageName());
        $intoDB = Photo::create(['name' => $this->getImageName(), 'user_id' => $this->user->id]);
        if ($intoDB) {
            $this->user->update(['current_photo' => $this->getImageName()]);
            $this->dispatchBrowserEvent('hide-form');
            $this->dispatchBrowserEvent('FireAlert', ['title' => 'Mise à jour réussie', 'message' => "La mise à jour de votre profil s'est bien déroulée", 'type' => 'success']);
            $this->emit("userProfilUpdate", $this->user->id);
        }
        else{
            $local = Storage::delete($this->getImageName());
            $this->dispatchBrowserEvent('FireAlert', ['title' => 'Ereur serveur', 'message' => "La mise à jour de votre profil a échoué, veuillez réessayer!", 'type' => 'error']);
            $this->user_profil->storeAs('profilPhotos', $this->getImageName());
        }
        
    }


    public function setImageName($extension)
    {
        $name = getdate()['year'].''.getdate()['mon'].''.getdate()['hours'].''.getdate()['minutes'].''.getdate()['seconds']. '' .  Str::random(15) . '.' . $extension;
        $this->photoName = $name;
        return $this;
    }

    public function getImageName()
    {
        return $this->photoName;
    }

    public function userProfilUpdate($id)
    {
        // 
    }
}
