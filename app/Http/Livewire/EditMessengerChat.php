<?php

namespace App\Http\Livewire;

use App\Models\Chat;
use Livewire\Component;

class EditMessengerChat extends Component
{

    protected $listeners = ['targetedMessage'];
    public $targetMessage;

    public function render()
    {
        return view('livewire.edit-messenger-chat');
    }


    public function targetedMessage($message_id)
    {
        $this->targetMessage = $message_id;
        // dd($message_id, $this->targetMessage);
    }

}
