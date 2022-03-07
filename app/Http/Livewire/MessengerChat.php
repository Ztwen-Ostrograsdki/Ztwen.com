<?php

namespace App\Http\Livewire;

use App\Models\Chat;
use App\Models\User;
use App\Models\UserOnlineSession;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class MessengerChat extends Component
{
    public $receiver;
    public $sender;
    public $actionIsActive = false;
    public $users;
    public $allMessages = [];
    public $activeMSGK;
    public $newMessage = '';
    public $deletedMessage;
    public $replyTo;
    public $id_targeted;
    public $connectedUsers;
    public $targetedMessage;
    public $allUsers;
    public $errorTexto = false;
    protected $listeners = ['refreshUsersList', 'chatReceiver', 'targetedMessage', 'newUserConnected'];
    protected $rules = [
        'newMessage' => 'required|string|between:5,255',
    ];

    public function mount()
    {   
        $id = (int)request()->id;
        $this->sender = Auth::user();
        $this->getUsers();
        $this->allUsers = $this->users->count() + 1;
        $this->getConnectedUsers();

        if($id){
            $user = User::find($id);
            if($user && !Auth::user()->isMyFriend($id)){
                return abort(403, "Vous n'êtes pas authorisé à écrire à ". $user->name);
            }
            elseif(!$user){
                return abort(403, "Mr/Mme ". Auth::user()->name ." Votre requête est inconnue");
            }
            $this->setReceiver($id);
        }
        else{
            
        }

        
    }

    public function boot()
    {
        
    }

    public function booted()
    {
        $this->refreshMessages();
    }


    public function newUserConnected()
    {
        $this->getConnectedUsers();
    }

    public function getConnectedUsers()
    {
        $this->connectedUsers = count(UserOnlineSession::all()->pluck('user_id'));
    }

    public function getUsers()
    {
        $this->users = User::all()->except(Auth::user()->id);
    }

    public function setReceiver($receiver_id)
    {
        $this->id_targeted = $receiver_id;
        $this->receiver = User::find($receiver_id);
        Auth::user()->refreshUnreadMessagesOf($this->receiver->id);
        $this->allMessages = $this->getTheseMessages($this->sender->id, $this->receiver->id, 7);

    }


    public function render()
    {
        return view('livewire.messenger-chat');
    }

    public function refreshUsersList()
    {
        return $this->getUsers();
    }

    public function sendMessage()
    {
        $this->resetErrors();
        if($this->newMessage == '')
        {
            $this->errorTexto = true;
        }else{
            Chat::create([
                'message' => $this->newMessage,
                'sender_id' => $this->sender->id,
                'receiver_id' => $this->receiver->id,
            ]);
        }
        $this->newMessage = "";
        $this->dispatchBrowserEvent('clear-textarea');

    }

    public function resetErrors()
    {
        $this->errorTexto = false;
        $this->mount($this->receiver->id);
    }

    public function getTheseMessages($sender, $receiver, $limit = 7)
    {
        $messages = [];
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

    public function refreshMessages()
    {
        if($this->receiver){
            $id = $this->receiver->id;
            $this->setReceiver($id);
        }
    }

    public function chatReceiver($receiver)
    {
        $this->setReceiver($receiver);
    }

    public function getUnreadMessages($user)
    {
        return $this->sender->getUnreadMessagesOf($user);
    }


    public function targetedMessage($message_id)
    {
        $message = Chat::withTrashed('deleted_at')->whereId($this->targetedMessage)->first();
        if($message->deleted_at){
            $this->deletedMessage = true;
        }
        return $this->targetedMessage = $message_id;
    }

    public function toggleAction($key, $message_id)
    {
        $this->actionIsActive = false;
        $this->activeMSGK = $key;
        $this->targetedMessage = $message_id;
        $this->actionIsActive = true;
    }

    public function deleteMessage($message_id)
    {
        if($message_id !== $this->targetedMessage){
            return abort(403, "Requête inconnue");
        }
        $message = Chat::withTrashed('deleted_at')->whereId($this->targetedMessage)->first();
        if ($message->sender_id == Auth::user()->id && $message->receiver_id == $this->receiver->id) {
            if($message->deleted_at){
                $message->forceDelete();
            }
            $message->delete();
            $this->actionIsActive = false;
            $this->dispatchBrowserEvent('hide-form');
            $this->dispatchBrowserEvent('MessageDeleted');
            $this->reset('targetedMessage');
        }
        else{
            $this->actionIsActive = false;
            $this->dispatchBrowserEvent('hide-form');
            $this->dispatchBrowserEvent('MessageDeleted');
            $this->reset('targetedMessage');
            return abort(403, "Vous n'êtes pas authorisé");
        }
        
    }

    public function cancel()
    {
        $this->dispatchBrowserEvent('hide-form');
        $this->actionIsActive = false;
        $this->reset('targetedMessage');
        $this->reset('deletedMessage');
    }


}
