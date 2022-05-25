<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Comment;
use App\Models\Product;
use Livewire\Component;
use App\Models\MyNotifications;
use Illuminate\Support\Facades\Auth;

class CommentManager extends Component
{
    protected $listeners = ['addNewComment'];
    public $comment;
    public $product;
    public $errorComment = false;
    public $approved = false;
    protected $rules = [
        'comment' => 'required|string|between:2,255',
    ];
    public function mount()
    {
        if(session()->has('newComment')){
            $this->comment = session('newComment');
        }
    }

    public function render()
    {
        return view('livewire.comment-manager');
    }



    public function addNewComment($product_id)
    {
        $product = Product::find($product_id);
        if($product){
            $this->product = $product;
            $this->dispatchBrowserEvent('modal-addNewComment');
        }
        else{
            return abort(403, "Votre requête ne peut aboutir");
        }
    }

    public function create()
    {
        $this->resetErrorBag();
        $user = Auth::user();
        if($user){
            if($this->validate()){
                $sentence = " Il sera traité et approuvé par les administrateurs avant d'être posté";
                if($user->role == 'admin' || $user->id == 1){
                    $this->approved = true;
                    $sentence = "";
                }
                $com = Comment::create([
                    'user_id' => $user->id,
                    'product_id' => $this->product->id,
                    'content' => $this->comment,
                    'approved' => $this->approved,
                ]);
                if($com){
                    $admins = User::where('id', 1)->orWhere('role', 'admin')->get()->except($user->id);
                    foreach ($admins as $admin){
                        MyNotifications::create([
                            'content' => mb_strtoupper($user->name) . " a posté un commentaire: {$this->comment}; sur un article",
                            'user_id' => $admin->id,
                            'comment_id' => $com->id,
                            'target' => "Articles",
                            'target_id' => $this->product->id,
                        ]);
                    }
                    $this->emit('newCommentAdd', $this->product->id);
                    session()->forget('newComment');
                    $this->reset('comment');
                    $this->resetErrorBag();
                    $this->dispatchBrowserEvent('hide-form');
                    $this->dispatchBrowserEvent('FireAlertDoNotClose', ['message' => "Votre commentaire a bien été soumis. $sentence", 'type' => 'success']);
                }
                else{
                    $this->dispatchBrowserEvent('FireAlertDoNotClose', ['message' => "Erreur serveur : Votre commentaire n'a peu être soumis. Votre commentaire a été gardé en session. Veuillez réessayer!", 'type' => 'warning']);
                }
                
            }
        }
        else{
            session()->put('newComment', $this->comment);
            $this->addError('comment', "Veuillez vous connecter avant de poster un commentaire");
            $this->dispatchBrowserEvent('FireAlertDoNotClose', ['message' => "Veuillez vous connecter en premier lieu. Votre commentaire a été gardé en session.", 'type' => 'question']);
        }
    }
}
