<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NotificationsCenter extends Component
{
    public $myNotifications;
    public $user;
    protected $listeners = ['newCommentAdd', 'adminKeyGenerated'];
    

    public function mount()
    {
        $user = Auth::user();

        if($user){
            $this->user = $user;
            $this->myNotifications = $user->myNotifications;
        }
        
    }

    public function render()
    {
        return view('livewire.notifications-center');
    }

    public function adminKeyGenerated($product_id)
    {
        $this->mount();
    }
    public function newCommentAdd($product_id)
    {
        $this->mount();
    }
}
