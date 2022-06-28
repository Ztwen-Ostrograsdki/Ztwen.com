<?php
namespace App\Helpers\UserTraits;

use App\Models\Chat;
use App\Models\User;

trait ChatManageTrait {


    /**
     * Use to get the last message of the conversation between the current user and his friend
     *
     * @param integer $friend_id [id of the friend]
     * @return mixed Array|null
     */
    public function __getLastMessage(int $friend_id)
    {
        $friend = User::find($friend_id);
        if($friend){
            $message = Chat::withTrashed('deleted_at')
                    ->where('sender_id', $this->id)
                    ->where('receiver_id', $friend->id)
                    ->orWhere('sender_id', $friend->id)
                    ->orWhere('receiver_id', $this->id)
                    ->orderBy('created_at', 'DESC')
                    ->first();
            return ($message && ($message->sender_id == $friend->id || $message->receiver_id == $friend_id))  ? $message : null;
        }
        else{
            return null;
        }
        
    }


    public function __getUsersOrderedByMessagesDate($target = null)
    {
        $users = [];
        $allUsers = User::all()->except([$this->id]);


        if($allUsers->count() < 1){
            return $users;
        }

        $messages = Chat::withTrashed('deleted_at')
                    ->where('sender_id', $this->id)
                    ->orWhere('receiver_id', $this->id)
                    ->orderBy('created_at', 'desc')
                    ->get();
        if($messages->count() > 0){
            foreach($messages as $m){
                if($m->receiver_id === $this->id){
                    $user = User::find($m->sender_id);
                    if($user){
                        $users[$m->sender_id] = $user;
                    }
                }
                else{
                    $user = User::find($m->receiver_id);
                    if($user){
                        $users[$m->receiver_id] = $user;
                    }
                }
            }
        }

        // foreach($allUsers as $user){
        //     if(!isset($users[$user->id])){
        //         $users[$user->id] = $user;
        //     }
        // }

        return $users;

        
        
    }


    public function __updateMessageHasSeen($friend_id, $last = null)
    {
        $messages = Chat::where('sender_id', $this->id)
                                    ->Where('receiver_id', $friend_id)
                                    ->Where('seen', false)
                                    ->orderBy('created_at', 'desc');
        if($messages->get()->count() > 0){
            if($last){
                $messages->first()->update(['seen' => true]);
            }
            else{
                foreach($messages->get() as $m){
                    $m->update(['seen' => true]);
                }
            }
        }
    }




    
}