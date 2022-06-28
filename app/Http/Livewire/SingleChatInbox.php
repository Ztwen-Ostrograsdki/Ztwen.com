<?php

namespace App\Http\Livewire;

use App\Models\Chat;
use App\Models\User;
use Livewire\Component;
use App\Events\NewMessageEvent;
use App\Events\IsTypingMessageEvent;

class SingleChatInbox extends Component
{
    public $user;
    public $defaultLimit = 4;
    public $limit = 4;
    public $receiver;
    public $TheseMessages = [];
    public $texto;
    public $total;
    public $deletedMessage;
    public $replyTo;
    public $id_targeted;
    public $targetedMessage;
    public $activeMSGK;
    public $errorTexto = false;
    public $show_message = false;
    public $actionIsActive = false;
    protected $listeners = ['newSingleChat', 'IHaveNewMessageEvent' => 'reloadMessages'];
    protected $rules = [
        'texto' => 'required|string|between:1,255',
    ];

    public function render()
    {
        $allMessages = $this->TheseMessages;
        return view('livewire.single-chat-inbox', ['allMessages' => $allMessages]);
    }

    public function updatedTexto($texto)
    {
        broadcast(new IsTypingMessageEvent($this->receiver));
        $this->reloadMessages($this->receiver);
    }

    public function reloadMessages($receiver = null)
    {
        if($this->receiver){
            $this->getTotal();
            $this->TheseMessages = $this->getTheseMessages($this->user->id, $this->receiver->id);
        }
    }


    public function newSingleChat($receiver_id)
    {
        $receiver = User::find($receiver_id);
        if($receiver){
            if(auth()->user()){
                $this->user = auth()->user();
                $this->receiver = $receiver;
                $this->getTotal();
                $this->TheseMessages = $this->getTheseMessages($this->user->id, $receiver_id);
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

    public function getTotal()
    {
        $receiver = $this->receiver->id;
        $sender = $this->user->id;
        $this->total = Chat::withTrashed('deleted_at')
            ->where('sender_id', $sender)
            ->where('receiver_id', $receiver)
            ->orWhere('sender_id', $receiver)
            ->orWhere('receiver_id', $sender)
            ->latest()
            ->count();
    }

    public function getTheseMessages($sender, $receiver, $limit = 4)
    {
        $ms = Chat::withTrashed('deleted_at')
            ->where('sender_id', $sender)
            ->where('receiver_id', $receiver)
            ->orWhere('sender_id', $receiver)
            ->orWhere('receiver_id', $sender)
            ->latest()
            ->limit($this->limit)
            ->get()
            ->reverse();
        foreach ($ms as $m) {
            if(($m->sender_id == $sender || $m->sender_id == $receiver) && ($m->receiver_id == $sender || $m->receiver_id == $receiver))
            $messages[] = $m;
        }
        return $messages;
    }


    public function showMoreMessages()
    {
        $this->limit = $this->limit + 3;
        $this->reloadMessages($this->receiver);
    }
    public function showLessMessages()
    {
        $this->limit = $this->defaultLimit;
        $this->reloadMessages($this->receiver);
    }

    


    public function send()
    {
        $this->errorTexto = false;
        if($this->validate()){
            $this->show_message = true;
            $create = Chat::create([
                'message' => $this->texto,
                'sender_id' => $this->user->id,
                'receiver_id' => $this->receiver->id,
            ]);
            if($create){
                broadcast(new NewMessageEvent($this->receiver));
                $this->reset('texto');
                $this->reloadMessages($this->receiver);
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
    }

    
    public function deleteMessage($message_id)
    {
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
        
    }

    public function cancel()
    {
        $this->dispatchBrowserEvent('hide-form');
        $this->actionIsActive = false;
        $this->reset('targetedMessage');
        $this->reset('deletedMessage');
    }

}
