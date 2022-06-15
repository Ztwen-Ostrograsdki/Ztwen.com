<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Comment;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\MyNotifications;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\ActionsTraits\ModelActionTrait;


class Admin extends Component
{
    use ModelActionTrait;


    protected $listeners = [
        'newUserAdded', 
        'refreshUsersList', 
        'newCommentAdd', 
        'newProductCreated',
        'newCategoryCreated',
        'thisAuthenticationIs'
    ];
    public $active = 'active';
    public $search;
    public $showSearch = false;
    public $user;
    public $u_u_id;
    public $u_u_key;
    public $show_token = false;
    public $adminTagName;
    public $adminTagTitle;
    public $users;
    public $unconfirmed;
    public $adminTrashedData = false;
    public $admins;
    public $comments;
    public $categories;
    public $products;
    public $role;
    public $currentUsersProfil;
    public $classMapping;

    public function mount()
    {
        $this->user = auth()->user();
        if(session()->has('adminTagName') && session()->has('adminTagTitle')){
            $this->adminTagName = session('adminTagName');
            $this->adminTagTitle = session('adminTagTitle');
        }
        else{
            $this->adminTagName = "notifications";
            $this->adminTagTitle = "Notifications";
        }
        if(session()->has('adminTrashedData') && session('adminTrashedData')){
            $this->adminTrashedData = session('adminTrashedData');
            $this->products = Product::onlyTrashed()->orderBy('slug', 'asc')->get();
            $this->categories = Category::onlyTrashed()->orderBy('name', 'asc')->get();
            $this->admins = User::onlyTrashed()->where('role', 'admin')->orderBy('name', 'asc')->get();
            $this->users = User::onlyTrashed()->orderBy('name', 'asc')->get();
            $this->unconfirmed = User::orderBy('name', 'asc')->whereNotNull('email_verified_token')->whereNotNull('token')->whereNull('email_verified_at')->get();
        }
        else{
            $this->users = User::orderBy('name', 'asc')->get();
            $this->unconfirmed = User::orderBy('name', 'asc')->whereNotNull('email_verified_token')->whereNotNull('token')->whereNull('email_verified_at')->get();
            $this->categories = Category::orderBy('name', 'asc')->get();
            $this->admins = User::where('role', 'admin')->orderBy('name', 'asc')->get();
            $this->products = Product::orderBy('slug', 'asc')->get();
        }
        $this->comments = Comment::all()->reverse();

        $this->getUsers();
    }

    public function toogleSearchBanner()
    {
        $this->showSearch = !$this->showSearch;
    }

    public function updatedSearch($v)
    {
        if($v && strlen($v) >= 3){
            $searchTerm = '%'.$v.'%';
            if(in_array($this->adminTagName, ['users', 'unconfirmed', 'admins'])){
                if(session()->has('adminTrashedData') && session('adminTrashedData')){
                    $this->adminTrashedData = session('adminTrashedData');
                    $based = User::onlyTrashed()->orderBy('name', 'asc')->where('name','like', $searchTerm)->orWhere('email','like', $searchTerm);
                }
                else{
                    $based = User::orderBy('name', 'asc')->where('name','like', $searchTerm)->orWhere('email','like', $searchTerm);
                }
                
                $this->unconfirmed = $based->whereNotNull('email_verified_token')->whereNotNull('token')->whereNull('email_verified_at')->get();
                $this->admins = $based->where('role', 'admin')->get();
                $this->users = $based->get();
            }
            else{
                if(session()->has('adminTrashedData') && session('adminTrashedData')){
                    $this->adminTrashedData = session('adminTrashedData');
                    if($this->adminTagName == 'products'){
                        $this->products = Product::onlyTrashed()->orderBy('slug', 'asc')->where('slug','like', $searchTerm)->orWhere('description','like', $searchTerm)->get();
                    }
                    elseif($this->adminTagName == 'categories'){
                        $this->categories = Category::onlyTrashed()->orderBy('name', 'asc')->where('name','like', $searchTerm)->orWhere('description','like', $searchTerm)->get();
                    }
                }
                else{
                    if($this->adminTagName == 'products'){
                        $this->products = Product::orderBy('slug', 'asc')->where('slug','like', $searchTerm)->orWhere('description','like', $searchTerm)->get();
                    }
                    elseif($this->adminTagName == 'categories'){
                        $this->categories = Category::orderBy('name', 'asc')->where('name','like', $searchTerm)->orWhere('description','like', $searchTerm)->get();
                    }
                }
                
            }
        }
        else{
            $this->mount();
        }
    }

    public function render()
    {
        return view('livewire.admin');
    }

    public function regenerateAdminKey()
    {
        $make = $this->user->__regenerateAdminKey();
        if($make){
            $this->dispatchBrowserEvent('Toast', ['type' => 'success', 'title' => 'CLE MODIFIEE AVEC SUCCES',  'message' => "La clé a été générée avec succès"]);
        }
        else{
            $this->dispatchBrowserEvent('Toast', ['type' => 'error', 'title' => "ERREUR", 'message' => "La clé n'a pas pu être générée! Veuillez réessayer!"]);
        }
    }
    
    public function displayAdminSessionKey()
    {
        $this->dispatchBrowserEvent('ToastDoNotClose', ['type' => 'info', 'title' => "LA CLE", 'message' => $this->user->__getKeyNotification()]);
    }

    public function destroyAdminSessionKey()
    {
        return $this->user->__destroyAdminKey();
    }

    public function newUserAdded($user)
    {
        $this->mount();
    }

    public function setActiveTag($name, $title)
    {
        $this->adminTagTitle = $title;
        $this->adminTagName = $name;
        session()->put('adminTagName',$name);
        session()->put('adminTagTitle',$title);
    }


    public function getTheTrashedData()
    {
        $this->adminTrashedData = true;
        session()->put('adminTrashedData', $this->adminTrashedData);
        $this->products = Product::onlyTrashed()->orderBy('slug', 'asc')->get();
        $this->categories = Category::onlyTrashed()->orderBy('name', 'asc')->get();
        $this->users = User::onlyTrashed()->orderBy('name', 'asc')->get();
        $this->admins = User::onlyTrashed()->where('role', 'admin')->orderBy('name', 'asc')->get();
    }

    public function getTheActiveData()
    {
        $this->adminTrashedData = false;
        session()->put('adminTrashedData', $this->adminTrashedData);
        $this->users = User::orderBy('name', 'asc')->get();
        $this->categories = Category::orderBy('name', 'asc')->get();
        $this->admins = User::where('role', 'admin')->orderBy('name', 'asc')->get();
        $this->products = Product::orderBy('slug', 'asc')->get();
    }


    public function openSingleChat($receiver_id)
    {
        $this->emit('newSingleChat', $receiver_id);
        $this->mount();
    }

    public function toogle_u_u($key)
    {
        $this->show_token = !$this->show_token;
        $this->u_u_key = $key;
    }


    public function refreshUsersList()
    {
        return $this->getUsers();
    }

    public function getUsers()
    {
        $data = User::all();
        foreach ($data as $u) {
            if ($u->currentPhoto() !== []) {
                $this->currentUsersProfil[$u->id] = $u->currentPhoto();
                
            }
            else{
                $this->currentUsersProfil[$u->id] = '';
            }
        }
        return $this->users = $data;
    }

    public function updateUserRole($userId, $role)
    {
        $user = User::find($userId);
        if($user){
            $user->update(['role' => $role]);
            $this->emit("refreshUsersList");
            $this->dispatchBrowserEvent('FireAlert', ['type' => 'success', 'message' => "L'utilisateur $user->name a désormais un rôle $role",  'title' => 'Réussie']);
        }else{
            return abort(403, "Vous n'êtes pas authorisé!");
        }
        $this->mount();
    }

    public function verifiedThisUserMail($user_id)
    {
        $user = User::find($user_id);
        if($user){
            if(!$user->hasVerifiedEmail()){
                $user->markEmailAsVerified();
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'success', 'message' => "L'utilisateur {$user->name} a été confirmé avec succès",  'title' => 'Email confirmé']);
                $this->mount();
            }
            else{
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'warning', 'message' => "L'utilisateur {$user->name} a déjà confirmé son adresse mail",  'title' => 'Echec']);
            }
        }
        else{
            $this->dispatchBrowserEvent('FireAlert', ['type' => 'error', 'message' => "Votre requête semble être corrompue",  'title' => 'Erreur serveur']);
        }
    }

    
    public function deleteAUser($user_id)
    {
        $user = User::find($user_id);
        if($user){
            if($user->deleteThisModel(false)){
                $this->emit('aUserHasBeenDeleted', $user->id);
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'success', 'message' => "L'utilisateur {$user->name} a été envoyé dans la corbeile avec succès",  'title' => 'Réussie']);
                $this->mount();
            }
            else{
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'error ', 'message' => "La suppression de l''utilisateur {$user->name} a échoué",  'title' => 'Echec']);
            }
        }
    }
    public function blockAUser($user_id)
    {
        $user = User::find($user_id);
        if($user){
            if($user->__blockThisUser()){
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'success', 'message' => "L'utilisateur {$user->name} a été bloqué avec succès",  'title' => 'Réussie']);
                $this->mount();
            }
            else{
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'error ', 'message' => "Le blocage de l''utilisateur {$user->name} a échoué",  'title' => 'Echec']);
            }
        }
    }
    public function restoreAUser($user_id)
    {
        $user = User::withTrashed('deleted_at')->whereId($user_id)->firstOrFail();
        if($user){
            if($user->restoreThisModel()){
                $this->emit('aUserHasBeenRestored', $user->id);
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'success', 'message' => "L'utilisateur {$user->name} a été restauré avec succès",  'title' => 'Réussie']);
                $this->mount();
            }
            else{
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'error ', 'message' => "La restauration de l''utilisateur {$user->name} a échoué",  'title' => 'Echec']);
            }
        }
    }
    public function unblockAUser($user_id)
    {
        $user = User::withTrashed('deleted_at')->whereId($user_id)->firstOrFail();
        if($user){
            if($user->__unblockThisUser()){
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'success', 'message' => "L'utilisateur {$user->name} a été débloqué avec succès",  'title' => 'Réussie']);
                $this->mount();
            }
            else{
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'error ', 'message' => "Le déblocage de l''utilisateur {$user->name} a échoué",  'title' => 'Echec']);
            }
        }
    }

    public function forceDeleteAUser($user_id)
    {
        $user = User::find($user_id);
        if($user){
            if($user->deleteThisModel(true)){
                $user->__deletedMyFollowSystemRequests();
                $this->emit('aUserHasBeenDeleted', $user->id);
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'success', 'message' => "L'utilisateur {$user->name} a été supprimé définivement avec succès",  'title' => 'Réussie']);
                $this->mount();
            }
            else{
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'error ', 'message' => "La suppression définitive de l''utilisateur {$user->name} a échoué",  'title' => 'Echec']);
            }
        }
    }


    //COMMENTS

    public function newCommentAdd($product_id)
    {
        $this->comments = Comment::all()->reverse();
    }
    
    public function refreshCommentsData()
    {
        $this->comments = Comment::all()->reverse();
    }

    public function approvedAComment($comment_id)
    {
        $comment = Comment::where('id', $comment_id)->firstOrFail();
        if($comment){
            $comment->update(['approved' => true]);
            $this->comments = Comment::all()->reverse();
            if($comment->user->id !== 1 && $comment->user->role !== 'admin'){
                MyNotifications::create([
                    'content' => "Votre commentaire : {$comment->content}; a été approuvé!",
                    'user_id' => $comment->user_id,
                    'comment_id' => $comment->id,
                    'target' => "Commentaires",
                    'target_id' => $comment->product->id
                ]);
            }
            $this->dispatchBrowserEvent('FireAlertDoNotClose', ['type' => 'success ', 'message' => "Le commentaire posté par {$comment->user->name} a été approuvé et sera désormais visible sur la plateforme part tous les utilisateurs"]);
        }
        else{
            $this->dispatchBrowserEvent('FireAlertDoNotClose', ['type' => 'error ', 'message' => "Le commentaire que vous rechercher n'existe pas"]);
        }
    }

    public function deleteAComment($comment_id)
    {
        $comment = Comment::find($comment_id);
        if($comment){
            if($comment->deleteThisModel(false)){
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'success', 'message' => "Le commentaire posté par {$comment->user->name} a été supprimé avec succès",  'title' => 'Réussie']);
                $this->mount();
            }
            else{
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'error ', 'message' => "La suppression du commentaire a échoué",  'title' => 'Echec']);
            }
        }
    }
    
    public function deleteNotApprovedComments()
    {
        $this->mount();
    }

    public function deleteAllComments()
    {
        $this->classMapping = Comment::class;
        $this->emit('__throwAuthenicationModal');
        $this->mount();
    }


    public function thisAuthenticationIs($response)
    {
        if($response){
            $this->__truncateModel($this->classMapping, $response);
            $this->dispatchBrowserEvent('FireAlertDoNotClose', ['type' => 'success ', 'message' => "Les données de la classe {{$this->classMapping}} ont été refraichies avec succès!",  'title' => "Authentification approuvée"]);
            $this->mount();
        }
        else{
            $this->dispatchBrowserEvent('FireAlert', ['type' => 'error', 'message' => "Vous n'êtes pas authorisé",  'title' => "Echec d'authentification"]);
            $this->mount();
        }
    }


    // CATEGORIES
    public function deleteACategory($category_id)
    {
        $category = Category::find($category_id);
        if($category){
            if($category->deleteThisModel(false)){
                $products = $category->products;
                if($category->products->count() > 0){
                    foreach ($products as $p){
                        $p->deleteThisModel(false);
                    }
                }
                $this->emit('aCategoryHasBeenDeleted', $category->id);
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'success', 'message' => "La catégorie {$category->name} a été envoyé dans la corbeile avec succès",  'title' => 'Réussie']);
                $this->mount();
            }
            else{
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'error ', 'message' => "La suppression de la catégorie {$category->name} a échoué",  'title' => 'Echec']);
            }
        }
    }
    public function restoreACategory($category_id)
    {
        $category = Category::withTrashed('deleted_at')->whereId($category_id)->firstOrFail();
        if($category){
            if($category->restoreThisModel()){
                $products = Product::onlyTrashed()->where('category_id', $category->id)->get();
                if($products->count() > 0){
                    foreach ($products as $p){
                        $p->restoreThisModel();
                    }
                }
                $this->emit('aCategoryHasBeenRestored', $category->id);
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'success', 'message' => "La catégorie {$category->name} a été restauré avec succès",  'title' => 'Réussie']);
                $this->mount();
            }
            else{
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'error ', 'message' => "La restauration de la catégorie {$category->name} a échoué",  'title' => 'Echec']);
            }
        }
    }

    public function editACategory($category_id)
    {
        $category = Category::withTrashed('deleted_at')->whereId($category_id)->firstOrFail();
        if($category){
            $this->emit('targetedCategory', $category->id);
        }
    }

    
    //PRODUCTS
    public function editAProduct($product_id)
    {
        $product = Product::withTrashed('deleted_at')->whereId($product_id)->firstOrFail();
        if($product){
            $this->emit('editAProduct', $product->id);
            $this->dispatchBrowserEvent('modal-editProduct');
        }
    }

    public function deleteAProduct($product_id)
    {
        $product = Product::find($product_id);
        if($product){
            if($product->deleteThisModel(false)){
                $this->emit('aProductHasBeenDeleted', $product->id);
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'success', 'message' => "L'article {$product->getName()} a été envoyé dans la corbeile avec succès",  'title' => 'Réussie']);
                $this->mount();
            }
            else{
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'error ', 'message' => "La suppression de l'article {$product->getName()} a échoué",  'title' => 'Echec']);
            }
        }
    }

    public function forceDeleteAProduct($product_id)
    {
        $product = Product::withTrashed('deleted_at')->where('id', $product_id)->firstOrFail();
        if($product){
            if($product->deleteThisModel(true)){
                $this->emit('aProductHasBeenDeleted', $product->id);
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'success', 'message' => "L'article {$product->getName()} a été supprimé définivement avec succès",  'title' => 'Réussie']);
                $this->mount();
            }
            else{
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'error ', 'message' => "La suppression de l'article {$product->getName()} a échoué",  'title' => 'Echec']);
            }
        }
    }

    public function hideThisProduct($product_id)
    {
        $product = Product::find($product_id);
        if($product){
            if($product->deleteThisModel(false)){
                $this->emit('aProductHasBeenDeleted', $product->id);
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'success', 'message' => "L'article {$product->getName()} a été masqué avec succès",  'title' => 'Réussie']);
                $this->mount();
            }
            else{
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'error ', 'message' => "Le retrait de l'article {$product->getName()} a échoué",  'title' => 'Echec']);
            }
        }
    }

    
    public function restoreThisProduct($product_id)
    {
        $product = Product::onlyTrashed()->where('id', $product_id)->firstOrFail();
        $category = Category::whereId($product->category_id)->first();
        if($product){
            if($category){
                if($product->restoreThisModel()){
                    $this->mount();
                    $this->emit('aProductHasBeenRestored', $product->id);
                    $this->dispatchBrowserEvent('FireAlert', ['type' => 'success', 'message' => "L'article {$product->getName()} a été restauré avec succès",  'title' => 'Réussie']);
                }
                else{
                    $this->dispatchBrowserEvent('FireAlert', ['type' => 'error ', 'message' => "La restauration de l'article {$product->getName()} a échoué",  'title' => 'Echec']);
                }
            }
            else{
                $category = Category::onlyTrashed()->whereId($product->category_id)->first();
                if($category){
                    $this->dispatchBrowserEvent('FireAlertDoNotClose', ['type' => 'error ', 'message' => "Cet article {$product->getName()} est lié à une catégorie retirée, ou supprimée! Veuillez restaurer en premier la catégorie. Il s'agit de la catégorie: {$category->name}",  'title' => 'Echec']);
                }
                else{
                    return abort(403, "Votre requête ne peut aboutir; les données sont corrompues");
                }
            }
        }

    }

    public function newProductCreated()
    {
        $this->products = Product::orderBy('slug', 'asc')->get();
    }

    public function newCategoryCreated($category_id = null)
    {
        $this->categories = Category::orderBy('name', 'asc')->get();
    }


}
