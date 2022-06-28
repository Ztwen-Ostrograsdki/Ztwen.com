<?php

namespace App\Http\Livewire;

use App\Models\Chat;
use App\Models\User;
use Livewire\Component;
use App\Events\NewMessageEvent;
use App\Events\IsTypingMessageEvent;
use Illuminate\Support\Facades\Auth;

class Messenger extends Component
{
    
    protected $listeners = ['chatReceiver', 'IHaveNewMessageEvent' => 'reloadNewMessages'];
    protected $rules = [
        'texto' => 'required|string|between:1,255',
    ];
    public $user;
    public $typing = false;
    public $receiver = null;
    public $texto = '';
    public $role;
    public $target = null;
    public $profil_path1 = '/myassets/profils/profil-1.jpg';
    public $profil_path2 = '/myassets/profils/profil-2.jpg';

    public function render()
    {
        $user = auth()->user();
        if($this->target && $this->target !== ''){
            $users = $this->getUsers();
        }
        else{
            $users = User::find($user->id)->__getUsersOrderedByMessagesDate($this->target);
        }
        $allMessages = $this->getTheseMessages($user, $this->receiver, 6);
        return view('livewire.messenger', compact('users', 'user', 'allMessages'));
    }

    public function setReceiver($receiver_id)
    {
        $user = User::find(auth()->user()->id);
        $user->__updateMessageHasSeen($receiver_id);
        $this->receiver = User::find($receiver_id);
    }

    public function updatedTarget($value)
    {
        $this->target = $value;
    }


    public function getTheseMessages($sender, $receiver, $limit = 7)
    {
        $messages = [];
        if(!$this->receiver){
            return $messages;
        }
        $sender = $sender->id;
        $receiver = $receiver->id;
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


    public function newUserAdded($user)
    {
        $this->user = $user;
    }

    public function refreshUsersList()
    {
        return $this->getUsers();
    }
    
    public function newUserConnected()
    {
        return $this->getUsers();
    }


    public function getUsers()
    {
        $value = $this->target;
        $users = [];
        if($value && mb_strlen($value) >= 3){
            $based = User::orderBy('name', 'asc')->where('name','like', $value)->orWhere('email','like', $value)->get();
            if(count($based) > 0){
                foreach($based as $b){
                    $users[$b->id] = $b;
                }
            }
            else{

                // return [];
            }
        }
        else{
            // return [];
        }

        return $users;
    }

    public function chatReceiver($receiver)
    {
        $this->receiver = $receiver;
        $this->emit('chatReceiver', $this->receiver);
    }

    public function updatedTexto($texto)
    {
        broadcast(new IsTypingMessageEvent($this->receiver));
        $this->reloadMessages($this->receiver);
    }

    public function reloadMessages($receiver)
    {
        $this->setReceiver($receiver->id);
    }

    public function reloadNewMessages($sender_id)
    {
        $sender = User::find($sender_id);
        $this->setReceiver($this->receiver->id);
    }


    public function send()
    {
        if($this->validate()){
            $create = Chat::create([
                'message' => $this->texto,
                'sender_id' => auth()->user()->id,
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

}
