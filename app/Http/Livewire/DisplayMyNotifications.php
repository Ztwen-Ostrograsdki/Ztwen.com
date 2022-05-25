<?php

namespace App\Http\Livewire;

use App\Models\MyNotifications;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class DisplayMyNotifications extends Component
{

    public $myNotifications;
    public $user;
    public $total = 0;
    protected $listeners = ['openModalForMyNotifications'];
    

    public function render()
    {
        return view('livewire.display-my-notifications');
    }


    public function getData()
    {
        $user = Auth::user();
        if($user){
            $this->user = $user;
            $this->myNotifications = $user->myNotifications->reverse();
            $this->total = $user->myNotifications->count();
        }

    }

    public function openModalForMyNotifications()
    {
        $this->getData();
        $this->dispatchBrowserEvent('modal-displayMyNotifications');
    }


    public function deleteThis($notification_id = null)
    {
        if($notification_id){
            $notif = MyNotifications::find($notification_id);
            if($notif){
                $notif->delete();
                $this->dispatchBrowserEvent('FireAlertDoNotClose', ['message' => "La notification a bien été supprimée", 'type' => 'success']);
            }
            else{
                $this->dispatchBrowserEvent('FireAlertDoNotClose', ['message' => "La suppression de la notification a écchoué", 'type' => 'error']);
            }
        }
        else{
            $notifs = $this->user->myNotifications;
            foreach($notifs as $notif){
                $notif->delete();
            }
            $this->dispatchBrowserEvent('FireAlertDoNotClose', ['message' => "Votre boite de notification a été rafraichi avec succès", 'type' => 'success']);
        }
        $this->getData();

    }
}
