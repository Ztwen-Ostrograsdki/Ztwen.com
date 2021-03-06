<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Comment;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use App\Models\MyNotifications;
use App\Helpers\ActionsTraits\ModelActionTrait;


class Admin extends Component
{
    use ModelActionTrait;


    protected $listeners = [
        'thisAuthenticationIs',
        'notifyMeWhenNewUserRegistred' => 'refreshDataOnEvent',
        'notifyMeWhenNewCommentHasBeenPosted' => 'refreshDataOnEvent',
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
    public $classMapping;
    public $dataShouldBeRefresh = false;

    public function refreshDataOnEvent($user = null)
    {
        $this->reset('dataShouldBeRefresh');
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
        return view('livewire.admin', compact('users', 'carts', 'admins', 'comments', 'categories', 'products', 'unconfirmed'));
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
            $this->dispatchBrowserEvent('Toast', ['type' => 'success', 'title' => 'CLE MODIFIEE AVEC SUCCES',  'message' => "La cl?? a ??t?? g??n??r??e avec succ??s"]);
        }
        else{
            $this->dispatchBrowserEvent('Toast', ['type' => 'error', 'title' => "ERREUR", 'message' => "La cl?? n'a pas pu ??tre g??n??r??e! Veuillez r??essayer!"]);
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
            $this->dispatchBrowserEvent('FireAlert', ['type' => 'success', 'message' => "L'utilisateur $user->name a d??sormais un r??le $role",  'title' => 'R??ussie']);
        }else{
            return abort(403, "Vous n'??tes pas authoris??!");
        }
    }

    public function verifiedThisUserMail($user_id)
    {
        $user = User::find($user_id);
        if($user){
            if(!$user->hasVerifiedEmail()){
                $user->markEmailAsVerified();
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'success', 'message' => "L'utilisateur {$user->name} a ??t?? confirm?? avec succ??s",  'title' => 'Email confirm??']);
            }
            else{
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'warning', 'message' => "L'utilisateur {$user->name} a d??j?? confirm?? son adresse mail",  'title' => 'Echec']);
            }
        }
        else{
            $this->dispatchBrowserEvent('FireAlert', ['type' => 'error', 'message' => "Votre requ??te semble ??tre corrompue",  'title' => 'Erreur serveur']);
        }
    }

    
    public function deleteAUser($user_id)
    {
        $user = User::find($user_id);
        if($user){
            if($user->deleteThisModel(false)){
                $this->emit('aUserHasBeenDeleted', $user->id);
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'success', 'message' => "L'utilisateur {$user->name} a ??t?? envoy?? dans la corbeile avec succ??s",  'title' => 'R??ussie']);
            }
            else{
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'error ', 'message' => "La suppression de l''utilisateur {$user->name} a ??chou??",  'title' => 'Echec']);
            }
        }
    }
    public function blockAUser($user_id)
    {
        $user = User::find($user_id);
        if($user){
            if($user->__blockThisUser()){
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'success', 'message' => "L'utilisateur {$user->name} a ??t?? bloqu?? avec succ??s",  'title' => 'R??ussie']);
            }
            else{
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'error ', 'message' => "Le blocage de l''utilisateur {$user->name} a ??chou??",  'title' => 'Echec']);
            }
        }
    }
    public function restoreAUser($user_id)
    {
        $user = User::withTrashed('deleted_at')->whereId($user_id)->firstOrFail();
        if($user){
            if($user->restoreThisModel()){
                $this->emit('aUserHasBeenRestored', $user->id);
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'success', 'message' => "L'utilisateur {$user->name} a ??t?? restaur?? avec succ??s",  'title' => 'R??ussie']);
            }
            else{
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'error ', 'message' => "La restauration de l''utilisateur {$user->name} a ??chou??",  'title' => 'Echec']);
            }
        }
    }
    public function unblockAUser($user_id)
    {
        $user = User::withTrashed('deleted_at')->whereId($user_id)->firstOrFail();
        if($user){
            if($user->__unblockThisUser()){
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'success', 'message' => "L'utilisateur {$user->name} a ??t?? d??bloqu?? avec succ??s",  'title' => 'R??ussie']);
            }
            else{
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'error ', 'message' => "Le d??blocage de l''utilisateur {$user->name} a ??chou??",  'title' => 'Echec']);
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
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'success', 'message' => "L'utilisateur {$user->name} a ??t?? supprim?? d??finivement avec succ??s",  'title' => 'R??ussie']);
            }
            else{
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'error ', 'message' => "La suppression d??finitive de l''utilisateur {$user->name} a ??chou??",  'title' => 'Echec']);
            }
        }
    }


    //COMMENTS

    public function approvedAComment($comment_id)
    {
        $comment = Comment::where('id', $comment_id)->firstOrFail();
        if($comment){
            $comment->update(['approved' => true]);
            if($comment->user->id !== 1 && $comment->user->role !== 'admin'){
                MyNotifications::create([
                    'content' => "Votre commentaire : {$comment->content}; a ??t?? approuv??!",
                    'user_id' => $comment->user_id,
                    'comment_id' => $comment->id,
                    'target' => "Commentaires",
                    'target_id' => $comment->product->id
                ]);
            }
            $this->dispatchBrowserEvent('FireAlertDoNotClose', ['type' => 'success ', 'message' => "Le commentaire post?? par {$comment->user->name} a ??t?? approuv?? et sera d??sormais visible sur la plateforme part tous les utilisateurs"]);
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
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'success', 'message' => "Le commentaire post?? par {$comment->user->name} a ??t?? supprim?? avec succ??s",  'title' => 'R??ussie']);
            }
            else{
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'error ', 'message' => "La suppression du commentaire a ??chou??",  'title' => 'Echec']);
            }
        }
    }
    
    public function deleteNotApprovedComments()
    {
    }

    public function deleteAllComments()
    {
        // $this->emit('__throwAuthenticationModal');
    }

    public function advancedRequests($classMapping)
    {
        $this->classMapping = $classMapping;
        $this->emit('startAdvancedRequests', $classMapping);
    }


    public function thisAuthenticationIs($response)
    {
        if($response){
            $this->__truncateModel($this->classMapping, $response);
            $this->dispatchBrowserEvent('FireAlertDoNotClose', ['type' => 'success ', 'message' => "Les donn??es de la classe {{$this->classMapping}} ont ??t?? refraichies avec succ??s!",  'title' => "Authentification approuv??e"]);
        }
        else{
            $this->dispatchBrowserEvent('FireAlert', ['type' => 'error', 'message' => "Vous n'??tes pas authoris??",  'title' => "Echec d'authentification"]);
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
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'success', 'message' => "La cat??gorie {$category->name} a ??t?? envoy?? dans la corbeile avec succ??s",  'title' => 'R??ussie']);
            }
            else{
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'error ', 'message' => "La suppression de la cat??gorie {$category->name} a ??chou??",  'title' => 'Echec']);
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
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'success', 'message' => "La cat??gorie {$category->name} a ??t?? restaur?? avec succ??s",  'title' => 'R??ussie']);
            }
            else{
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'error ', 'message' => "La restauration de la cat??gorie {$category->name} a ??chou??",  'title' => 'Echec']);
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
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'success', 'message' => "L'article {$product->getName()} a ??t?? envoy?? dans la corbeile avec succ??s",  'title' => 'R??ussie']);
            }
            else{
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'error ', 'message' => "La suppression de l'article {$product->getName()} a ??chou??",  'title' => 'Echec']);
            }
        }
    }

    public function forceDeleteAProduct($product_id)
    {
        $product = Product::withTrashed('deleted_at')->where('id', $product_id)->firstOrFail();
        if($product){
            if($product->deleteThisModel(true)){
                $this->emit('aProductHasBeenDeleted', $product->id);
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'success', 'message' => "L'article {$product->getName()} a ??t?? supprim?? d??finivement avec succ??s",  'title' => 'R??ussie']);
            }
            else{
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'error ', 'message' => "La suppression de l'article {$product->getName()} a ??chou??",  'title' => 'Echec']);
            }
        }
    }

    public function hideThisProduct($product_id)
    {
        $product = Product::find($product_id);
        if($product){
            if($product->deleteThisModel(false)){
                $this->emit('aProductHasBeenDeleted', $product->id);
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'success', 'message' => "L'article {$product->getName()} a ??t?? masqu?? avec succ??s",  'title' => 'R??ussie']);
            }
            else{
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'error ', 'message' => "Le retrait de l'article {$product->getName()} a ??chou??",  'title' => 'Echec']);
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
                    $this->dispatchBrowserEvent('FireAlert', ['type' => 'success', 'message' => "L'article {$product->getName()} a ??t?? restaur?? avec succ??s",  'title' => 'R??ussie']);
                }
                else{
                    $this->dispatchBrowserEvent('FireAlert', ['type' => 'error ', 'message' => "La restauration de l'article {$product->getName()} a ??chou??",  'title' => 'Echec']);
                }
            }
            else{
                $category = Category::onlyTrashed()->whereId($product->category_id)->first();
                if($category){
                    $this->dispatchBrowserEvent('FireAlertDoNotClose', ['type' => 'error ', 'message' => "Cet article {$product->getName()} est li?? ?? une cat??gorie retir??e, ou supprim??e! Veuillez restaurer en premier la cat??gorie. Il s'agit de la cat??gorie: {$category->name}",  'title' => 'Echec']);
                }
                else{
                    return abort(403, "Votre requ??te ne peut aboutir; les donn??es sont corrompues");
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
            $this->dispatchBrowserEvent('FireAlertDoNotClose', ['type' => 'error ', 'message' => "Cet article n'existe pas ou d??j?? ??t?? supprim??!",  'title' => 'Echec']);
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

    public function getCategories()
    {
        $categories = [];
        if(session()->has('adminTrashedData') && session('adminTrashedData')){
            $this->adminTrashedData = session('adminTrashedData');
            $categories = Category::onlyTrashed()->orderBy('name', 'asc')->get();
        }
        else{
            $categories = Category::orderBy('name', 'asc')->get();
        }
        return $categories;
    }


    public function getProducts()
    {
        $products = [];
        if(session()->has('adminTrashedData') && session('adminTrashedData')){
            $this->adminTrashedData = session('adminTrashedData');
            $products = Product::onlyTrashed()->orderBy('slug', 'asc')->get();
        }
        else{
            $products = Product::orderBy('slug', 'asc')->get();
        }
        
        return $products;
    }


    public function getUsers()
    {
        $users = [];
        if(session()->has('adminTrashedData') && session('adminTrashedData')){
            $this->adminTrashedData = session('adminTrashedData');
            $users = User::onlyTrashed()->orderBy('name', 'asc')->get();
        }
        else{
            $users = User::orderBy('name', 'asc')->get();
        }

        return $users;
    }


    public function getAdmins()
    {
        $admins = [];
        if(session()->has('adminTrashedData') && session('adminTrashedData')){
            $this->adminTrashedData = session('adminTrashedData');
            $admins = User::onlyTrashed()->where('role', 'admin')->orderBy('name', 'asc')->get();
        }
        else{
            $admins = User::where('role', 'admin')->orderBy('name', 'asc')->get();
        }
        return $admins;
    }

    public function getUnconfirmedUsers()
    {
        $unconfirmed = [];
        if(session()->has('adminTrashedData') && session('adminTrashedData')){
            $this->adminTrashedData = session('adminTrashedData');
            $unconfirmed = User::orderBy('name', 'asc')->whereNotNull('email_verified_token')->whereNotNull('token')->whereNull('email_verified_at')->get();
        }
        else{
            $unconfirmed = User::orderBy('name', 'asc')->whereNotNull('email_verified_token')->whereNotNull('token')->whereNull('email_verified_at')->get();
        }
        
        return $unconfirmed;
    }

    public function getComments()
    {
        return Comment::all()->reverse();
    }

}
