<?php

namespace App\Http\Livewire;

use App\Models\Chat;
use App\Models\User;
use Livewire\Component;

class SingleChatInbox extends Component
{
    public $user;
    public $defaultLimit = 3;
    public $limit = 3;
    public $total;
    public $receiver;
    public $texto;
    public $allMessages = [];
    public $deletedMessage;
    public $replyTo;
    public $id_targeted;
    public $targetedMessage;
    public $activeMSGK;
    public $errorTexto = false;
    public $show_message = false;
    public $actionIsActive = false;
    protected $listeners = ['newSingleChat'];
    protected $rules = [
        'texto' => 'required|string|between:1,255',
    ];

    public function render()
    {
        return view('livewire.single-chat-inbox');
    }


    public function newSingleChat($receiver_id)
    {
        $receiver = User::find($receiver_id);
        if($receiver){
            if(auth()->user()){
                $this->user = auth()->user();
                $this->receiver = $receiver;
                $this->setTheMessages($this->user->id, $receiver_id, 3);
                $this->dispatchBrowserEvent('modal-openSingleChatModal');
            }
            else{
                return redirect(route('login'));
            }
            
        }
        else{
            return abort(403, "Votre requête ne peut aboutir");
        }
    }

    public function getTheseMessages($sender, $receiver, $limit = 7)
    {
        $messages = [];
        $this->total = Chat::withTrashed('deleted_at')
            ->where('sender_id', $sender)
            ->where('receiver_id', $receiver)
            ->orWhere('sender_id', $receiver)
            ->orWhere('receiver_id', $sender)
            ->latest()
            ->count();
        $ms = Chat::withTrashed('deleted_at')
            ->where('sender_id', $sender)
            ->where('receiver_id', $receiver)
            ->orWhere('sender_id', $receiver)
            ->orWhere('receiver_id', $sender)
            ->latest()
            ->limit($limit)
            ->get()
            ->reverse();
        foreach ($ms as $m) {
            if(($m->sender_id == $sender || $m->sender_id == $receiver) && ($m->receiver_id == $sender || $m->receiver_id == $receiver))
            $messages[] = $m;
        }
        return $messages;

    }


    public function setTheMessages($sender = null, $receiver = null, $limit = 7)
    {
        if(!$sender && !$receiver){
            $sender = $this->user->id;
            $receiver = $this->receiver->id;
        }
        $this->allMessages = $this->getTheseMessages($sender, $receiver, $this->limit);
    }

    public function showMoreMessages()
    {
        $this->limit = $this->limit + 3;
        $this->setTheMessages($this->user->id, $this->receiver->id, $this->limit);
    }
    public function showLessMessages()
    {
        $this->limit = $this->defaultLimit;
        $this->setTheMessages($this->user->id, $this->receiver->id, $this->limit);
    }

    


    public function send()
    {
        $this->setTheMessages($this->user->id, $this->receiver->id, 3);

        $this->errorTexto = false;
        if($this->validate()){
            $this->show_message = true;
            $create = Chat::create([
                'message' => $this->texto,
                'sender_id' => $this->user->id,
                'receiver_id' => $this->receiver->id,
            ]);
            if($create){
                $this->emit('messageHasBeenSend', $create->sender_id);
                $this->texto = "";
                // $this->show_message = false;
                $this->setTheMessages($this->user->id, $this->receiver->id, 3);
            }
        }
        else{
            $this->errorTexto = true;
        }
        
    }

    public function toggleAction($key, $message_id)
    {
        if($this->actionIsActive && $this->targetedMessage == $message_id){
            $this->reset('targetedMessage', 'activeMSGK', 'actionIsActive');
        }
        else{
            $this->actionIsActive = false;
            $this->activeMSGK = $key;
            $this->targetedMessage = $message_id;
            $this->actionIsActive = true;
        }
        $this->setTheMessages($this->user->id, $this->receiver->id, 3);
    }

    
    public function deleteMessage($message_id)
    {
        $this->setTheMessages($this->user->id, $this->receiver->id, 3);
        if($message_id !== $this->targetedMessage){
            return abort(403, "Requête inconnue");
        }
        $message = Chat::withTrashed('deleted_at')->whereId($this->targetedMessage)->first();
        if ($message->sender_id == auth()->user()->id && $message->receiver_id == $this->receiver->id) {
            if($message->deleted_at){
                $message->deleteThisModel(true);
            }
            $message->deleteThisModel();
        }
        else{
            return abort(403, "Vous n'êtes pas authorisé");
        }
        $this->actionIsActive = false;
        $this->dispatchBrowserEvent('hide-form');
        $this->dispatchBrowserEvent('MessageDeleted');
        $this->reset('targetedMessage');
        $this->setTheMessages($this->user->id, $this->receiver->id, 3);
        
    }

    public function cancel()
    {
        $this->dispatchBrowserEvent('hide-form');
        $this->actionIsActive = false;
        $this->reset('targetedMessage');
        $this->reset('deletedMessage');
    }

}
