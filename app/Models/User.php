<?php

namespace App\Models;

use App\Models\Image;
use App\Models\Photo;
use App\Models\Comment;
use App\Models\History;
use App\Models\Product;
use App\Models\Reported;
use App\Models\MyRequest;
use App\Models\ShoppingBag;
use App\Models\UserAdminKey;
use Hamcrest\Type\IsInteger;
use App\Helpers\DateFormattor;
use App\Helpers\ProductManager;
use App\Models\MyNotifications;
use Laravel\Sanctum\HasApiTokens;
use App\Models\User as ModelsUser;
use App\Helpers\UserTraits\UserTrait;
use App\Models\ResetEmailConfirmation;
use Laravel\Jetstream\HasProfilePhoto;
use App\Helpers\AdminTraits\AdminTrait;
use Illuminate\Notifications\Notifiable;
use App\Helpers\UserTraits\ChatManageTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Fortify\TwoFactorAuthenticatable;
use App\Helpers\ActionsTraits\ModelActionTrait;
use App\Helpers\ActionsTraits\FollowSystemTrait;
use App\Helpers\UserTraits\MustVerifyEmailTrait;
use App\Helpers\UserTraits\UserPasswordManagerTrait;
use App\Helpers\ZtwenManagers\GaleryManager;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable

{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use SoftDeletes;
    use DateFormattor;
    use ModelActionTrait;
    use FollowSystemTrait;
    use MustVerifyEmailTrait;
    use AdminTrait;
    use UserPasswordManagerTrait;
    use UserTrait; 
    use ChatManageTrait;
    use GaleryManager;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'new_email',
        'password',
        'role',
        'current_photo',
        'email_verified_token',
        'new_email_verified_token',
        'reset_password_token',
        'blocked',
        'token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];


    public $imagesFolder = 'usersPhotos';


    public function likes()
    {
        return $this->hasMany(SeenLikeProductSytem::class);
    }

    public function userAdminKey()
    {
        return $this->hasOne(UserAdminKey::class);
    }
    
    public function images()
    {
        return $this->morphToMany(Image::class, 'imageable');
    }


    public function myRequests()
    {
        return $this->hasMany(MyRequest::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function histories()
    {
        return $this->hasMany(History::class);
    }


    public function isMyFriend($user)
    {
        if(is_int($user)){
            $user = User::find($user);
            if(!$user){
                return abort(403);
            }
        }
        $he_follow_me = FollowingSystem::where('follower_id', $user->id)->where('followed_id', $this->id)->where('accepted', true)->first();
        $i_follow_him = FollowingSystem::where('followed_id', $user->id)->where('follower_id', $this->id)->where('accepted', true)->first();
        if($i_follow_him || $he_follow_me){
            return true;
        }
        return false;
    }
    public function friendlySince($user)
    {
        $a = FollowingSystem::where('follower_id', $this->id)
                                        ->orWhere('followed_id', $user)
                                        ->where('accepted', true)
                                        ->first();
        $b = FollowingSystem::where('follower_id', $user)
                                        ->orWhere('followed_id', $this->id)
                                        ->where('accepted', true)
                                        ->first();
        if($a){
            return $a;
        }
        elseif($b){
            return $b;
        }
        else{
            return false;
        }
    }

    public function getMyFriends()
    {
        $myfriends = [];
        $sendByMe = FollowingSystem::where('follower_id', $this->id)
                                    ->where('accepted', true)
                                    ->get();
        $sendToMe = FollowingSystem::where('followed_id', $this->id)
                                    ->where('accepted', true)
                                    ->get();

        if(($sendByMe->count() + $sendToMe->count()) > 0){
            if($sendByMe->count() > 0){
                foreach ($sendByMe as $req) {
                    $user = User::find($req->followed_id);
                    if($user){
                        $myfriends[$req->followed_id] = $user;
                    }
                }
            }

            if($sendToMe->count() > 0){
                foreach ($sendToMe as $req) {
                    $user = User::find($req->follower_id);
                    if($user){
                        $myfriends[$req->follower_id] = $user;
                    }
                }
            }
        }
        return $myfriends;
    }



    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getUnreadMessagesOf($user)
    {
        
        $messages = Chat::where('sender_id', $user)
                        ->where('receiver_id', $this->id)
                        ->where('seen', false)
                        ->get();
        return $messages;
    }


    /**
     * To refresh the unread message of current model about an user
     *
     * @param [int] $user_id
     * @return void
     */
    public function refreshUnreadMessagesOf($user_id)
    {
        $messages = $this->getUnreadMessagesOf($user_id);
        foreach ($messages as $m){
            $m->update(['seen' => true]);
        }
    }

    public function iFollowingButNotYet($user)
    {
        $followed = FollowingSystem::where('followed_id', $user->id)->where('follower_id', $this->id)->where('accepted', false)->first();
        if($followed){
            return true;
        }
        return false;
    }

    public function iFollowThis($user)
    {
        $followed = FollowingSystem::where('followed_id', $user->id)->where('follower_id', $this->id)->where('accepted', true)->first();
        if($followed){
            return true;
        }
        return false;
    }

    public function getMyFollowers()
    {
        $myfollowers = [];
        $followers = FollowingSystem::where('followed_id', $this->id)->where('accepted', false)->get();
        if($followers->count() > 0){
            foreach ($followers as $f) {
                $myfollowers[] = User::find($f->follower_id);
            }
        }
        return $myfollowers;
    }

    public function getMyFolloweds()
    {
        $myfolloweds = [];
        $followeds = FollowingSystem::where('followed_id', $this->id)->where('accepted', true)->get();
        if($followeds->count() > 0){
            foreach ($followeds as $f) {
                $myfolloweds[] = User::find($f->followed_id);
            }
        }
    }

    public function myFriendsRequestsSent()
    {
        $tabs = [];
        $all = FollowingSystem::where('follower_id', $this->id)->where('accepted', false)->get();
        foreach ($all as $d) {
            $u = User::find($d->followed_id);
            if($u){
                $tabs[] = ['user' => $u, 'request' => $d];
            }
        }

        return $tabs;

    }

    public function shoppingBags()
    {
        return $this->hasMany(ShoppingBag::class);
    }

    public function getDateAgoFormated($created_at = false)
    {
        $this->__setDateAgo();
        if($created_at){
            return $this->dateAgoToString;
        }
        return $this->dateAgoToStringForUpdated;
    }

    
    public function myNotifications()
    {
        return $this->hasMany(MyNotifications::class);
    }


    public function reporteds()
    {
        return $this->hasMany(Reported::class);
    }

    public function emailConfirmation()
    {
        return $this->hasOne(ResetEmailConfirmation::class);
    }

}
