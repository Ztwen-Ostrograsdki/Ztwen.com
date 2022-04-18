<?php

namespace App\Models;

use App\Models\Image;
use App\Models\Photo;
use App\Models\Comment;
use App\Models\History;
use App\Models\Product;
use App\Models\MyRequest;
use App\Models\ShoppingBag;
use Hamcrest\Type\IsInteger;
use App\Helpers\ProductManager;
use Laravel\Sanctum\HasApiTokens;
use App\Models\User as ModelsUser;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
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
    use ProductManager;


    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'current_photo',
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


    public function images()
    {
        return $this->hasMany(Image::class);
    }
    public function myRequests()
    {
        return $this->hasMany(MyRequest::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function histories()
    {
        return $this->hasMany(History::class);
    }

    public function currentPhoto()
    {
        $photos = $this->photos;
        if($photos->toArray() !== []){
            return $this->current_photo;
        }
        return $this->defaultProfil();
    }

    public function myGalery()
    {
        $photos = $this->photos;
        if($photos->toArray() !== []){
            return $this->photos;
        }
        return [];
    }

    public function isMyFriend($user)
    {
        if($this->role == 'admin' || $this->id == 1){
            return true;
        }
        if(is_int($user)){
            $user = User::find($user);
            if(!$user){
                return abort(403);
            }
        }
        $he_follow_me = FollowingSystem::where('follower_id', $user->id)->where('followed_id', $this->id)->where('accepted', true)->first();
        $i_follow_him = FollowingSystem::where('followed_id', $user->id)->where('follower_id', $this->id)->where('accepted', true)->first();
        if($i_follow_him && $he_follow_me){
            return true;
        }
        return false;
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

    /**
     * set a default profil photo for a model
     *
     * @return string
     */
    public function defaultProfil()
    {
        return Photo::DEFAULT_PROFIL_PHOTO_PATH;
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
        $followers = FollowingSystem::where('followed_id', $this->id)->where('accepted', true)->get();
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

    public function myFollowedsRequests()
    {
        $tabs = [];
        $all = FollowingSystem::where('followed_id', $this->id)->where('accepted', false)->get();
        foreach ($all as $d) {
            $u = User::find($d->follower_id);
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

    public function alreadyIntoCart($product_id)
    {
        $product = Product::find($product_id);
        if($product){
            $alreadyIntoCart = ShoppingBag::where('user_id', $this->id)->where('product_id', $product->id)->get();
            if($alreadyIntoCart->count() > 0){
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return abort(403, "Votre requête ne peut aboutir");
        }
    }


}
