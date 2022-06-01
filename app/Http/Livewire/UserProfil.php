<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Product;
use Livewire\Component;
use App\Models\UserAdminKey;
use Livewire\WithFileUploads;
use App\Helpers\ProfilManager;
use App\Models\MyNotifications;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserProfil extends Component
{
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
    public $user;
    public $carts;
    public $profilImage;
    public $activeTagName;
    public $activeTagTitle;
    public $demandes;
    public $myFriends = [];
    public $myFollowers = [];
    public $myProducts;
    public $myProductsComments = [];

    protected $listeners = ['userProfilUpdate', 'myCartWasUpdated', 'updateRequests'];
    protected $rules = [
        'name' => 'required|string|between:5,50',
        'email' => 'required|email',
        'code' => 'required|string',
        'new_password_confirmation' => 'required|string|between:4,40',
        'new_password' => 'required|string|confirmed|between:4,40',
        'old_pwd' => 'required|string|between:4,40',
    ];

    use WithFileUploads;


    public function mount(int $id)
    {
        if(Auth::user() && Auth::user()->id !== $id){
            return abort(403, "Vous n'êtes pas authorisé à cette page");
        }
        if($id){
            $user = User::find($id);
            if($user){
                $this->user = $user;
                $this->name = $this->user->name;
                $this->email = $this->user->email;
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
            $this->activeTagName = (new ProfilManager('demandes', "Les demandes envoyées"))->name;
            $this->activeTagTitle = (new ProfilManager('demandes', "Les demandes envoyées"))->title;
        }
        $this->getDemandes();
        $this->getMyFollowers();
        $this->myFriends = $this->user->getMyFriends();
        $this->profilImage = $this->user->currentPhoto();
        
        $this->getUserCart();

    }

    public function regenerateAdminKey()
    {
        return $this->user->__regenerateAdminKey();
    }
    public function destroyAdminSessionKey()
    {
        return $this->user->__destroyAdminKey();
    }

    public function getUserCart()
    {
        $this->carts = [];
        $carts = $this->user->shoppingBags->pluck('product_id')->toArray();
        if(count($carts) > 0){
            $this->carts = Product::whereIn('id', $carts)->get();
        }
    }

    public function getMyFollowers()
    {
        $this->myFollowers = $this->user->getMyFollowers();
    }

    public function render()
    {
        return view('livewire.user-profil');
        
    }
    public function updateRequests()
    {
        return $this->mount(auth()->user()->id);
    }

    public function userProfilUpdate($id)
    {
        return $this->mount($id);
    }

    public function setActiveTag($name, $title)
    {
        $this->activeTagName = (new ProfilManager($name, $title))->name;
        $this->activeTagTitle = (new ProfilManager($name, $title))->title;
        session()->put('userProfilTagName', $name);
        session()->put('userProfilTagTitle', $title);
        $this->mount($this->user->id);
    }
    public function getDemandes()
    {
        $user = Auth::user();
        if($user){
            $this->demandes = User::find($user->id)->myFriendsRequestsSent();
        }
        else{
            $this->demandes = [];
        }

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
        $this->mount($this->user->id);
        
    }

    public function cancelRequestFriend($user_id)
    {
        $auth = Auth::user()->id;
        $made = User::find($auth)->__cancelFriendRequest($user_id);
        if($made){
            $this->emit('updateRequests');
        }
        else{
            $this->dispatchBrowserEvent('FireAlertDoNotClose', ['type' => 'error', 'message' => "Une erreure inconnue s'est produite lors de la connexion au serveur"]);
        }
        $this->mount($this->user->id);
    }

    public function unfollowThis($user_id)
    {
        $auth = Auth::user()->id;
        $made = User::find($auth)->__unfollowThis($user_id);
        if($made){
            $this->emit('updateRequests');
        }
        else{
            $this->dispatchBrowserEvent('FireAlertDoNotClose', ['type' => 'error', 'message' => "Une erreure inconnue s'est produite lors de la connexion au serveur"]);
        }
        $this->mount($this->user->id);
    }

    public function followThisUser($user_id)
    {
        $auth = auth()->user()->id;
        $user = User::find($user_id);
        if(!$user){
            return abort(403, "Vous n'êtes pas authorisé");
        }
        if(User::find($auth)->__followThisUser($user->id)){
            $this->emit('updateRequests');
            $this->mount($this->user->id);
        }
        else{
            $this->dispatchBrowserEvent('FireAlertDoNotClose', ['type' => 'warning', 'message' => "Vous ne pouvez pas effectuer cette requête"]);
        }
        
    }

    public function liked($product_id)
    {
        $product = Product::find($product_id);
        if($product && $this->user){
            if($this->user->likedThis('product', $product->id, $this->user->id)){
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
        $this->mount(auth()->user()->id);
    }

    public function myCartWasUpdated()
    {
        $this->mount(auth()->user()->id);
    }


    public function editMyName()
    {
        dd(['u' => $this->user->myNotifications, 'a_n' => MyNotifications::all()], $this->user->userAdminKey, UserAdminKey::all());
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
        $old = User::withTrashed('deleted_at')->where('name', $this->name)->whereKeyNot($this->user->id)->first();
        if($old){
            $this->addError('name', "Ce nom est déjà existant !");
        }
        else{
            $this->user->update(['name' => $this->name]);
            $this->emit('userDataEdited', $this->user->id);
            $this->dispatchBrowserEvent('FireAlertDoNotClose', ['type' => 'success', 'message' => "La mise à jour de votre nom s'est bien déroulée!"]);
            $this->edit_name = false;
        }

    }

    public function changeEmail()
    {
        $old = User::withTrashed('deleted_at')->where('email', $this->email)->whereKeyNot($this->user->id)->first();
        if($old){
            $this->addError('email', "Cette adresse mail est déjà existante !");
        }
        else{
            // $sendToken = $this->user->__resetEmail($this->email);
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
        $old = User::withTrashed('deleted_at')->where('email', $this->email)->whereKeyNot($this->user->id)->first();
        if($old){
            $this->addError('email', "Cette adresse mail est déjà existante !");
        }
        else{
            $this->validate();
            $this->dispatchBrowserEvent('FireAlertDoNotClose', ['type' => 'success', 'message' => "La mise à jour de votre adresse mail s'est bien déroulée!"]);
            $this->reset('edit_email', 'code');
            $this->email = $this->user->email;
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
        if(!Hash::check($this->old_pwd, $this->user->password)){
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
        if(Hash::check($this->new_password, $this->user->password)){
            $this->addError('new_password', "Vous ne pouvez pas utiliser ce mot de passe");
            $this->addError('new_password_confirmation', "Vous ne pouvez pas utiliser ce mot de passe");
        }
        else{
            $this->user->forceFill([
                'password' => Hash::make($this->new_password),
            ])->save();
            $this->user->sendEmailForPasswordHaveBeenResetNotification();
            $this->dispatchBrowserEvent('FireAlertDoNotClose', ['type' => 'success', 'message' => "La mise à jour de votre mot de passe s'est bien déroulée!"]);
            $this->reset('edit_password', 'new_password', 'new_password_confirmation', 'old_pwd', 'psw_step_1', 'psw_step_2');
            return redirect()->route('login');
            
        }
    }

    public function cancelPasswordEdit()
    {
        $this->reset('edit_password', 'new_password', 'new_password_confirmation', 'old_pwd', 'psw_step_1', 'psw_step_2');
    }

    

}
