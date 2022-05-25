<?php
namespace App\Helpers\ActionsTraits;

use App\Models\User;
use App\Models\FollowingSystem;
use App\Models\MyNotifications;

/**
 * Trait to manage the follow system between two users
 */
trait FollowSystemTrait{


    /**
     * This method is used to follow a user
     *
     * @param int $user_id the id of the user that we want to follow
     * @param boolean $accepted
     * @return boolean
     */
    public function __followThisUser($user_id, $accepted = false)
    {
        $user = User::find($user_id);
        if(!$user){
            return false;
        }
        $old = FollowingSystem::where('follower_id', $this->id)->where('followed_id', $user->id)->where('accepted', false)->first();
        if($old){
            $old->delete();
        }
        $req = FollowingSystem::where('followed_id', $this->id)->where('follower_id', $user->id)->where('accepted', true)->first();
        if($req){
            return false;
        }
        else{
            $made = FollowingSystem::create(
                [
                    'follower_id' => $this->id,
                    'followed_id' => $user->id,
                    'accepted' => $accepted,
                ]);
            if($made){
                MyNotifications::create([
                    'content' => $this->name . " vous a envoyé une invitation!",
                    'user_id' => $user->id,
                    'target' => "Demande d'ajout",
                ]);
                return true;
            }
        }
    }


    /**
     * This method is used to manage a request that have sent to a current user
     *
     * @param int $user_id the id of the user that we want to follow
     * @param string $action [the action that we want to do Accepeted for true | refused for false]
     * @return boolean
     */
    public function __followRequestManager($user_id, $action)
    {
        $user = User::find($user_id);
        if(!$user){
            return false;
        }
        $req = FollowingSystem::where('follower_id', $user_id)->where('followed_id', $this->id)->first();
        if($req){
            if($action == "accepted"){
                if($req->update(['accepted' => true])){
                    $otherReq = FollowingSystem::where('followed_id', $user_id)->where('follower_id', $this->id)->first();
                    if($otherReq){
                        $otherReq->delete();
                    }
                    MyNotifications::create([
                        'content' => $this->name . " a accepté votre demande",
                        'user_id' => $user->id,
                        'target' => "Demande d'ajout",
                    ]);
                    return true;
                }
            }
            elseif($action == "refused"){
                $made = $req->delete();
                if($made){
                    return true;
                }
            }
            return false;
        }
        return false;
    }

    /**
     * This method is used to cancel a friend request sent
     *
     * @param [type] $user_id
     * @return boolean
     */
    public function __cancelFriendRequest($user_id)
    {
        $user = User::find($user_id);
        if(!$user){
            return false;
        }
        $req = FollowingSystem::where('follower_id', $this->id)->where('followed_id', $user->id)->first();
        if($req && $user){
            if($req->delete()){
                return true;
            }
            return false;
        }
        return false;
    }


    /**
     * This method is used to unfollow an user
     *
     * @param [type] $user_id
     * @return boolean
     */
    public function __unfollowThis($user_id)
    {
        $user = User::find($user_id);
        if(!$user){
            return false;
        }
        $req = FollowingSystem::where('follower_id', $this->id)->where('followed_id', $user->id)->first();
        if($req){
            if($req->update(['accepted' => false])){
               return true;
            }
            return false;
        }
        else{
            $req = FollowingSystem::where('followed_id', $this->id)->where('follower_id', $user->id)->first();
            if($req->update(['accepted' => false])){
                return true;
            }
            return false;
        }
        return false;
    }

    public function __deletedMyFollowSystemRequests()
    {
        $requests = FollowingSystem::where('followed_id', $this->id)->orWhere('follower_id', $this->id)->get();
        if($requests->count() > 0){
            foreach ($requests as $req){
                $req->delete();
            }
        }
    }





}