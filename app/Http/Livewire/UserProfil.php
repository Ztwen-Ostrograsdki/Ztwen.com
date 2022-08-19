<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Image;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Helpers\ProfilManager;
use App\Events\NewFollowerEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserProfil extends Component
{
    public $haveNewFollower = false;
    public $hasNewData = false;
    public $edit_name = false;
    public $edit_email = false;
    public $edit_password = false;
    public $confirm_email_field = false;
    public $psw_step_1 = false;
    public $psw_step_2 = false;
    public $show_old_pwd = false;
    public $show_new_pwd = false;
    public $new_password;
    public $old_pwd;
    public $new_password_confirmation;
    public $name;
    public $code;
    public $email;
    public $new_email;
    public $user_id;
    public $carts_counter;
    public $activeTagName;
    public $activeTagTitle;

    protected $listeners = [
        'userProfilUpdate', 
        'myCartWasUpdated', 
        'updateRequests', 
        'notifyMeWhenNewFollower',
        'IsendNewFriendRequest_L_Event' => 'notifyMeWhenNewFollower',
    ];
    protected $rules = [
        'name' => 'required|string|between:5,50',
        'email' => 'required|email',
        'new_email' => 'required|email',
        'code' => 'required|string',
        'new_password_confirmation' => 'required|string|between:4,40',
        'new_password' => 'required|string|confirmed|between:4,40',
        'old_pwd' => 'required|string|between:4,40',
    ];

    use WithFileUploads;


    public function render()
    {
        $this->hasNewData = true;
        $user = User::find(auth()->user()->id);
        $myFollowers = $this->getMyFollowers();
        $myFriends = $user->getMyFriends();
        $this->getUserCart();
        $demandes = $this->getDemandes();

        return view('livewire.user-profil', compact('demandes', 'myFollowers', 'myFriends', 'user'));
    }

    public function mount(int $id)
    {
        if(Auth::user() && Auth::user()->id !== $id){
            return abort(403, "Vous n'êtes pas authorisé à cette page");
        }
        if($id){
            $user = User::find($id);
            if($user){
                $this->user_id = $id;
                $this->name = $user->name;
                $this->email = $user->email;
                $this->new_email = $user->new_email;
            }
            else{
                return abort(403, "Votre requête ne peut aboutir");
            }
        }
        else{
            return abort(404, "La page que vous rechercher est introuvable!");
        }
        if(session()->has('userProfilTagName') && session()->has('userProfilTagTitle')){
            $this->activeTagName = session('userProfilTagName');
            $this->activeTagTitle = session('userProfilTagTitle');
        }
        else{
            $this->activeTagName = (new ProfilManager('editing', "Edition de profil"))->name;
            $this->activeTagTitle = (new ProfilManager('editing', "Edition de profil"))->title;
        }

    }

    public function booted()
    {
        return $this->mount(Auth::user()->id);
    }

    public function regenerateAdminKey()
    {
        $user = User::find(auth()->user()->id);
        $make = $user->__regenerateAdminKey();
        if($make){
            $this->dispatchBrowserEvent('Toast', ['type' => 'success', 'title' => 'CLE MODIFIEE AVEC SUCCES',  'message' => "La clé a été générée avec succès"]);
        }
        else{
            $this->dispatchBrowserEvent('Toast', ['type' => 'error', 'title' => "ERREUR", 'message' => "La clé n'a pas pu être générée! Veuillez réessayer!"]);
        }
    }

    public function displayAdminSessionKey()
    {
        $user = User::find(auth()->user()->id);
        $this->dispatchBrowserEvent('ToastDoNotClose', ['type' => 'info', 'title' => "LA CLE", 'message' => $user->__getKeyNotification()]);
    }

    public function destroyAdminSessionKey()
    {
        $user = User::find(auth()->user()->id);
        return $user->__destroyAdminKey();
    }

    public function getUserCart()
    {
        $data = Auth::user()->shoppingBags->pluck('product_id')->toArray();
        $this->carts_counter = count($data);
    }

    public function refreshCartsCounter()
    {
        $this->carts_counter = count(auth()->user()->shoppingBags->pluck('product_id')->toArray());
    }

    public function getMyFollowers()
    {
        $user = User::find(auth()->user()->id);
        return  $user->getMyFollowers();
    }

    public function updateRequests()
    {
    }

    public function userProfilUpdate($id)
    {
    }

    public function setActiveTag($name, $title)
    {
        $this->activeTagName = (new ProfilManager($name, $title))->name;
        $this->activeTagTitle = (new ProfilManager($name, $title))->title;
        session()->put('userProfilTagName', $name);
        session()->put('userProfilTagTitle', $title);
    }


    public function getDemandes()
    {
        $demandes = [];
        $user = Auth::user();
        if($user){
            $demandes = User::find($user->id)->myFriendsRequestsSent();
        }
        else{
            $demandes = [];
        }
        return $demandes;

    }

    public function requestManager($user_id, $action)
    {
        $auth = Auth::user()->id;
        $made = User::find($auth)->__followRequestManager($user_id, $action);
        if($made){
            $this->emit('updateRequests');
        }
        else{
            $this->dispatchBrowserEvent('FireAlertDoNotClose', ['type' => 'error', 'message' => "Une erreure inconnue s'est produite lors de la connexion au serveur"]);
        }
        
    }

    public function cancelRequestFriend($user_id)
    {
        $auth = Auth::user()->id;
        $foll_user = User::find($user_id);
        $made = User::find($auth)->__cancelFriendRequest($user_id);
        if($made){
            $this->emit('onUpdateUsersList_L_Event');
            $event = new NewFollowerEvent($foll_user, auth()->user(), 'retrieved');
            broadcast($event);
        }
        else{
            $this->dispatchBrowserEvent('FireAlertDoNotClose', ['type' => 'error', 'message' => "Une erreure inconnue s'est produite lors de la connexion au serveur"]);
        }
    }

    public function unfollowThis($user_id)
    {
        $auth = Auth::user()->id;
        $foll_user = User::find($user_id);
        $made = User::find($auth)->__unfollowThis($user_id);
        if($made){
            $event = new NewFollowerEvent($foll_user, 'retrieved');
            broadcast($event);
        }
        else{
            $this->dispatchBrowserEvent('FireAlertDoNotClose', ['type' => 'error', 'message' => "Une erreure inconnue s'est produite lors de la connexion au serveur"]);
        }
    }

    public function liked($product_id)
    {
        $product = Product::find($product_id);
        if($product && Auth::user()){
            $user = User::find(auth()->user()->id);
            if($user->likedThis('product', $product->id, $user->id)){
                $this->getUserCart();
            }
        }
        else{
            return abort(403, "Votre requête ne peut aboutir");
        }
    }


    public function openSingleChat($receiver_id)
    {
        $this->emit('newSingleChat', $receiver_id);
    }

    public function myCartWasUpdated($user_id = null)
    {
        $this->refreshCartsCounter();
    }


    public function editMyName()
    {
        $this->edit_email = false;
        $this->edit_password = false;
        $this->edit_name = !$this->edit_name;
    }
    

    public function editMyEmail()
    {
        $this->edit_name = false;
        $this->edit_password = false;
        $this->edit_email = !$this->edit_email;
    }

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function renamed()
    {
        $old = User::withTrashed('deleted_at')->where('name', $this->name)->whereKeyNot(Auth::user()->id)->first();
        if($old){
            $this->addError('name', "Ce nom est déjà existant !");
        }
        else{
            $user = User::find(auth()->user()->id);
            $user->update(['name' => $this->name]);
            $this->emit('userDataEdited', Auth::user()->id);
            $this->dispatchBrowserEvent('FireAlertDoNotClose', ['type' => 'success', 'message' => "La mise à jour de votre nom s'est bien déroulée!"]);
            $this->edit_name = false;
        }

    }

    public function changeEmail()
    {
        $old = User::withTrashed('deleted_at')->where('email', $this->new_email)->whereKeyNot(Auth::user()->id)->first();
        if($old){
            $this->addError('new_email', "Cette adresse mail est déjà existante !");
        }
        else{
            // $update = Auth::user()->__initialisedResetUserEmail($this->new_email);
            $sendToken = true;
            if($sendToken){
                $this->dispatchBrowserEvent('FireAlertDoNotClose', ['type' => 'warning', 'message' => "Nous procedons à la mise à jour de votre adresse mail, cependant  veuillez confirmer votre adresse à l'aide du code envoyé à l'adresse mail {$this->email} !"]);
                $this->confirm_email_field = true;
            }
            else{
                $this->dispatchBrowserEvent('FireAlertDoNotClose', ['title' => 'Erreur', 'type' => 'warning', 'message' => "Une erreure est survenue lors de la mise à jour de votre adresse mail!"]);
            }
        }
    }

    public function confirmedEmail()
    {
        $old = User::withTrashed('deleted_at')->where('email', $this->email)->whereKeyNot(Auth::user()->id)->first();
        if($old){
            $this->addError('email', "Cette adresse mail est déjà existante !");
        }
        else{
            $this->validate();
            $this->dispatchBrowserEvent('FireAlertDoNotClose', ['type' => 'success', 'message' => "La mise à jour de votre adresse mail s'est bien déroulée!"]);
            $this->reset('edit_email', 'code');
            $this->email = Auth::user()->email;
        }
    }



    public function toogleShowOldPassword()
    {
        $this->show_old_pwd = !$this->show_old_pwd;
    }
    public function toogleShowNewPassword()
    {
        $this->show_new_pwd = !$this->show_new_pwd;
    }

    public function editMyPassword()
    {
        $this->edit_name = false;
        $this->edit_email = false;
        $this->psw_step_2 = false;
        $this->psw_step_1 = !$this->psw_step_1;
        $this->edit_password = !$this->edit_password;
    }

    public function verifiedOldPassword()
    {
        $this->validate(['old_pwd' => 'required|string']);
        if(!Hash::check($this->old_pwd, Auth::user()->password)){
            $this->addError('old_pwd', "Le mot de passe ne correspond pas!");
        }
        else{
            $this->psw_step_1 = false;
            $this->psw_step_2 = !$this->psw_step_2;
        }
    }

    public function changePassword()
    {
        $this->validate([
            'new_password' => 'required|string|confirmed|between:4,40',
            'new_password_confirmation' => 'required|string|between:4, 40'
        ]);
        if(Hash::check($this->new_password, Auth::user()->password)){
            $this->addError('new_password', "Vous ne pouvez pas utiliser ce mot de passe");
            $this->addError('new_password_confirmation', "Vous ne pouvez pas utiliser ce mot de passe");
        }
        else{
            $user = User::find(auth()->user()->id);
            $user->forceFill([
                'password' => Hash::make($this->new_password),
            ])->save();
            $user->sendEmailForPasswordHaveBeenResetNotification();
            $this->dispatchBrowserEvent('FireAlertDoNotClose', ['type' => 'success', 'message' => "La mise à jour de votre mot de passe s'est bien déroulée!"]);
            $this->reset('edit_password', 'new_password', 'new_password_confirmation', 'old_pwd', 'psw_step_1', 'psw_step_2');
            return redirect()->route('login');
            
        }
    }

    public function cancelPasswordEdit()
    {
        $this->reset('edit_password', 'new_password', 'new_password_confirmation', 'old_pwd', 'psw_step_1', 'psw_step_2');
    }


    public function notifyMeWhenNewFollower($event = null)
    {
        $this->reset('hasNewData');
    }

    

}
