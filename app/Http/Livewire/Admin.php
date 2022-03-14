<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;


class Admin extends Component
{
    protected $listeners = ['newUserAdded', 'refreshUsersList'];
    public $user;
    public $users;
    public $role;
    public $currentUsersProfil;

    public function render()
    {
        $this->getUsers();
        return view('livewire.admin');
    }

    public function newUserAdded($user)
    {
        $this->user = $user;
    }

    public function refreshUsersList()
    {
        return $this->getUsers();
    }

    public function getUsers()
    {
        $data = User::all();
        foreach ($data as $u) {
            if ($u->currentPhoto() !== []) {
                $this->currentUsersProfil[$u->id] = $u->currentPhoto();
                
            }
            else{
                $this->currentUsersProfil[$u->id] = '';
            }
        }
        return $this->users = $data;
    }

    public function updateUserRole($userId, $role)
    {
        $user = User::find($userId);
        if($user){
            $user->update(['role' => $role]);
            $this->emit("refreshUsersList");
            $this->dispatchBrowserEvent('FireAlert', ['type' => 'success', 'message' => "L'utilisateur $user->name a désormais un rôle $role",  'title' => 'Réussie']);
        }else{
            return abort(403, "Vous n'êtes pas authorisé!");
        }
    }


}
