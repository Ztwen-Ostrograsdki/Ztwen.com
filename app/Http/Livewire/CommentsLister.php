<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use App\Models\Product;
use Livewire\Component;
use App\Models\MyNotifications;

class CommentsLister extends Component
{
    protected $listeners = ['onPageChangeFromOtherComponent' => 'changePage'];
    public $counter = 0;
    public $limit = 3;
    public $target = null;
    public $perPage;
    public $page;

    public function render()
    {
        if($this->target && $this->target == 'last'){
            $comments = Comment::where('blocked', 0)->where('approved', 1)->orderBy('created_at', 'desc')->take($this->limit)->get();
        }
        else{
            $comments = Comment::whereNotNull('created_at')->orderBy('created_at', 'desc')->paginate($this->perPage, ['*'], null, $this->page);
        }
        return view('livewire.comments-lister', compact('comments'));
    }

    public function changePage($page)
    {
        $this->page = $page;
    }

    
    public function loadProductImages($product_id)
    {
        $this->emit('loadProductImages', $product_id);
    }

    public function approvedAComment($comment_id)
    {
        $this->counter = 1;
        $comment = Comment::where('id', $comment_id)->firstOrFail();
        if($comment){
            $comment->update(['approved' => true]);
            if($comment->user->id !== 1 && $comment->user->role !== 'admin'){
                MyNotifications::create([
                    'content' => "Votre commentaire : {$comment->content}; a été approuvé!",
                    'user_id' => $comment->user_id,
                    'comment_id' => $comment->id,
                    'target' => "Commentaires",
                    'target_id' => $comment->product->id
                ]);
            }
            $this->dispatchBrowserEvent('Toast', ['type' => 'success', 'title' => 'Approbation de commentaire', 'message' => "Le commentaire posté par {$comment->user->name} a été approuvé et sera désormais visible sur la plateforme part tous les utilisateurs"]);
        }
        else{
            $this->dispatchBrowserEvent('FireAlertDoNotClose', ['type' => 'error', 'message' => "Le commentaire que vous rechercher n'existe pas"]);
        }
        $this->reset('counter');

    }

    public function deleteAComment($comment_id)
    {
        $this->counter = 1;
        $comment = Comment::find($comment_id);
        if($comment){
            if($comment->deleteThisModel(false)){
                $this->dispatchBrowserEvent('Toast', ['type' => 'success', 'message' => "Le commentaire posté par {$comment->user->name} a été supprimé avec succès",  'title' => 'Réussie']);
            }
            else{
                $this->dispatchBrowserEvent('Toast', ['type' => 'error ', 'message' => "La suppression du commentaire a échoué",  'title' => 'Echec']);
            }
        }
        $this->reset('counter');
    }

    public function editAProduct($product_id)
    {
        $product = Product::withTrashed('deleted_at')->whereId($product_id)->firstOrFail();
        if($product){
            $this->emit('editAProduct', $product->id);
            $this->dispatchBrowserEvent('modal-editProduct');
        }
    }
    




}
