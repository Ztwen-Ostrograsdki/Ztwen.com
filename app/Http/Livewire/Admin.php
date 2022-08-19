<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Comment;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use App\Helpers\ActionsTraits\ModelActionTrait;


class Admin extends Component
{
    use ModelActionTrait;


    protected $listeners = [
        'thisAuthenticationIs',
        'notifyMeWhenNewUserRegistred' => 'refreshDataOnEvent',
        'notifyMeWhenNewCommentHasBeenPosted' => 'refreshDataOnEvent',
        'reloadAdminComponent' => 'refreshDataOnEvent',
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
    public $adminTrashedData = false;
    public $role;
    public $currentUsersProfil;
    public $classMappingForAdvancedRequest;
    public $classMappingForSelecteds;
    public $selectedsTableHasSoftDelete = false;
    public $dataShouldBeRefresh = false;
    public $page;
    public $productsPerPage;
    public $usersPerPage;
    public $categoriesPerPage;
    public $commentsPerPage;
    public $notificationsPerPage;
    public $perPage = 6;
    public $selected;
    public $selectedAction;
    public $checkeds = [];
    public $selecteds = [];


    public function mount(
                $page = null, 
                $productsPerPage = null, 
                $usersPerPage = null,
                $categoriesPerPage = null,
                $commentsPerPage = null, 
                $notificationsPerPage = null
            ) 
    {
        $this->page = $page ?? 1;
        $this->productsPerPage = $productsPerPage ?? 10;
        $this->usersPerPage = $usersPerPage ?? 10;
        $this->categoriesPerPage = $categoriesPerPage ?? 10;
        $this->commentsPerPage = $commentsPerPage ?? 3;
        $this->notificationsPerPage = $notificationsPerPage ?? 10;
    }


    public function refreshDataOnEvent($user = null)
    {
        $this->reset('dataShouldBeRefresh');
    }
    public function resetCheckeds()
    {
        $this->reset('selecteds', 'selectedAction');
    }
    public function selectedThis($product_id)
    {
        if(in_array($product_id, $this->selecteds)){
            unset($this->selecteds[$product_id]);
        }
        else{
            $this->selecteds[$product_id] = $product_id;
        }
    }

    public function submitSelecteds()
    {
        $selecteds = $this->selecteds;
        if($selecteds !== [] && $this->selectedAction){
            $make = call_user_func_array(array(\App\Helpers\ModelsHelpers\TableManager::class, $this->selectedAction), [$this->classMappingForSelecteds]);
        }
    }

    public function setAction($action)
    {
        $activeTag = $this->adminTagName;
        $root = "\App\Models\\";
        $model = null;

        if(in_array($action, ['deleteMass', 'forceDeleteMass', 'resetGaleryMass', 'resetBasketMass', 'blockMass', 'restoreMass', 'confirmUserEmailMass'])){
            $this->selectedAction = $action;
        }
        else{
            return false;
        }

        if($activeTag == 'products'){
            $classMappingForSelecteds = $root . 'Product';
        }
        elseif($activeTag == 'categories'){
            $classMappingForSelecteds = $root . 'Category';
        }
        elseif($activeTag == 'comments'){
            $classMappingForSelecteds = $root . 'Comment';
        }
        elseif($activeTag == 'notifications'){
            $classMappingForSelecteds = $root . 'MyNotifications';
        }
        elseif(in_array($activeTag, ['users', 'admins', 'unconfirmed'])){
            $classMappingForSelecteds = $root . 'User';
        }

        $model = new $classMappingForSelecteds;
        $this->classMappingForSelecteds = $model;

    }

    public function initialiseData()
    {
        $this->dataShouldBeRefresh = true;
        if(session()->has('adminTagName') && session()->has('adminTagTitle')){
            $this->adminTagName = session('adminTagName');
            $this->adminTagTitle = session('adminTagTitle');
        }
        else{
            $this->adminTagName = "notifications";
            $this->adminTagTitle = "Notifications";
        }
    }

    public function render()
    {
        $this->initialiseData();
        $users = $this->getUsers();
        $carts = $this->getCarts();
        $admins = $this->getAdmins();
        $products = $this->getProducts();
        $categories = $this->getCategories();
        $comments = $this->getComments();
        $unconfirmed = $this->getUnconfirmedUsers();
        $active = $this->adminTagName;
        if($active == 'users'){
            $adminActiveData = $users;
        }
        elseif($active == 'admins'){
            $adminActiveData = $admins;
        }
        elseif($active == 'unconfirmed'){
            $adminActiveData = $unconfirmed;
        }
        elseif($active == 'products'){
            $adminActiveData = $products;
        }
        elseif($active == 'categories'){
            $adminActiveData = $categories;
        }
        elseif($active == 'comments'){
            $adminActiveData = $comments;
        }
        else{
            $adminActiveData = [];
        }
        return view('livewire.admin', compact('users', 'carts', 'admins', 'comments', 'categories', 'products', 'unconfirmed', 'adminActiveData'));
    }


    public function advancedRequests($classMappingForAdvancedRequest)
    {
        $this->emit('startAdvancedRequests', $classMappingForAdvancedRequest);
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
    
    public function generateAdvancedRequestsKey()
    {
        $user = User::find(auth()->user()->id);
        $make = $user->__generateAdvancedRequestKey();
        if($make){
            $this->dispatchBrowserEvent('ToastDoNotClose', ['type' => 'info', 'title' => "LA CLE", 'message' => $user->__getAdvancedKeyNotification()]);
        }
    }

    public function displayAdminSessionKey()
    {
        $user = User::find(auth()->user()->id);
        $this->dispatchBrowserEvent('ToastDoNotClose', ['type' => 'info', 'title' => "LA CLE", 'message' => $user->__getKeyNotification()]);
    }

    public function destroyAdminSessionKey()
    {
        return User::find(auth()->user()->id)->__destroyAdminKey();
    }

    public function setActiveTag($name, $title)
    {
        $this->reset('selecteds', 'selectedAction', 'page');
        $this->adminTagTitle = $title;
        $this->adminTagName = $name;
        session()->put('adminTagName',$name);
        session()->put('adminTagTitle',$title);
    }

    public function openSingleChat($receiver_id)
    {
        $this->emit('newSingleChat', $receiver_id);
    }

    public function toogle_u_u($key)
    {
        $this->show_token = !$this->show_token;
        $this->u_u_key = $key;
    }

    public function manageCart($cart_id)
    {
        $this->emit('openUserCartManager', $cart_id);
    }

    
    public function updateUserRole($userId, $role)
    {
        $user = User::find($userId);
        if($user){
            $user->update(['role' => $role]);
            $this->dispatchBrowserEvent('FireAlert', ['type' => 'success', 'message' => "L'utilisateur $user->name a désormais un rôle $role",  'title' => 'Réussie']);
        }else{
            return abort(403, "Vous n'êtes pas authorisé!");
        }
    }

    public function verifiedThisUserMail($user_id)
    {
        $user = User::find($user_id);
        if($user){
            if(!$user->hasVerifiedEmail()){
                $user->markEmailAsVerified();
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'success', 'message' => "L'utilisateur {$user->name} a été confirmé avec succès",  'title' => 'Email confirmé']);
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
            }
            else{
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'error ', 'message' => "La suppression définitive de l''utilisateur {$user->name} a échoué",  'title' => 'Echec']);
            }
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

    public function updateProductGalery($product_id)
    {
        $product = Product::find($product_id);
        if($product){
            $this->emit('targetedProduct', $product->id);
            $this->dispatchBrowserEvent('modal-updateProductGalery');
        }
        else{
            $this->dispatchBrowserEvent('FireAlertDoNotClose', ['type' => 'error ', 'message' => "Cet article n'existe pas ou déjà été supprimé!",  'title' => 'Echec']);
        }
        
    }



    public function getCarts()
    {
        $carts = [];
        $products = Product::all();
        foreach($products as $p){
            $p_carts = $p->shoppingBags;
            if($p_carts->count() > 0){
                $the_carts = [];
                foreach ($p_carts as $c) {
                    $the_carts[$c->user->id] = ['user' => $c->user, 'cart' => $c];
                }
                $carts[$p->id] = $the_carts;
            }
            else{
                $carts[$p->id] = null;
            }
        }
        return $carts;
    }

    public function setAdminTrashedData()
    {
        $this->adminTrashedData = true;
        session()->put('adminTrashedData', true);
        $this->adminTrashedData = session('adminTrashedData');
    }
    public function resetAdminTrashedData()
    {
        $this->adminTrashedData = false;
        session()->put('adminTrashedData', false);
        $this->adminTrashedData = session('adminTrashedData');
    }

    public function getCategories()
    {
        $categories = [];
        if(session()->has('adminTrashedData') && session('adminTrashedData')){
            $this->adminTrashedData = session('adminTrashedData');
            $categories = Category::onlyTrashed()->orderBy('name', 'asc')->paginate($this->categoriesPerPage, ['*'], null, $this->page);
        }
        else{
            $categories = Category::orderBy('name', 'asc')->paginate($this->categoriesPerPage, ['*'], null, $this->page);
        }
        return $categories;
    }


    public function getProducts()
    {
        $products = [];
        if(session()->has('adminTrashedData') && session('adminTrashedData')){
            $this->adminTrashedData = session('adminTrashedData');
            $products = Product::onlyTrashed()->orderBy('slug', 'asc')->paginate($this->productsPerPage, ['*'], null, $this->page);
        }
        else{
            $products = Product::orderBy('slug', 'asc')->paginate($this->productsPerPage, ['*'], null, $this->page);
        }
        
        return $products;
    }

    public function loadNextPage()
    {
        $this->page += 1;
        $this->emit('onPageChangeFromOtherComponent', $this->page);
    }

    public function loadPrevPage()
    {
        $this->page -= 1;
        $this->emit('onPageChangeFromOtherComponent', $this->page);
    }


    public function getUsers()
    {
        $users = [];
        if(session()->has('adminTrashedData') && session('adminTrashedData')){
            $this->adminTrashedData = session('adminTrashedData');
            $users = User::onlyTrashed()->orderBy('name', 'asc')->paginate($this->usersPerPage, ['*'], null, $this->page);
        }
        else{
            $users = User::orderBy('name', 'asc')->paginate($this->usersPerPage, ['*'], null, $this->page);
        }

        return $users;
    }


    public function getAdmins()
    {
        $admins = [];
        if(session()->has('adminTrashedData') && session('adminTrashedData')){
            $this->adminTrashedData = session('adminTrashedData');
            $admins = User::onlyTrashed()->where('role', 'admin')->orderBy('name', 'asc')->paginate($this->usersPerPage, ['*'], null, $this->page);
        }
        else{
            $admins = User::where('role', 'admin')->orderBy('name', 'asc')->paginate($this->usersPerPage, ['*'], null, $this->page);
        }
        return $admins;
    }

    public function getUnconfirmedUsers()
    {
        $unconfirmed = [];
        if(session()->has('adminTrashedData') && session('adminTrashedData')){
            $this->adminTrashedData = session('adminTrashedData');
            $unconfirmed = User::orderBy('name', 'asc')->whereNotNull('email_verified_token')->whereNotNull('token')->whereNull('email_verified_at')->paginate($this->usersPerPage, ['*'], null, $this->page);
        }
        else{
            $unconfirmed = User::orderBy('name', 'asc')->whereNotNull('email_verified_token')->whereNotNull('token')->whereNull('email_verified_at')->paginate($this->usersPerPage, ['*'], null, $this->page);
        }
        
        return $unconfirmed;
    }

    public function getComments()
    {
        if(session()->has('adminTrashedData') && session('adminTrashedData')){
            $this->adminTrashedData = session('adminTrashedData');
            return Comment::whereId(0)->paginate($this->categoriesPerPage, ['*'], null, $this->page);
        }
        else{
            return Comment::whereNotNull('created_at')->orderBy('created_at', 'desc')->paginate($this->commentsPerPage, ['*'], null, $this->page);
        }
    }

}
