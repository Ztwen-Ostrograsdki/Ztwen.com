<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use Livewire\Component;

class CommentsLister extends Component
{
    public $comments;

    protected $listeners = ['newCommentAdd'];

    
    public function render()
    {
        $this->comments = Comment::all()->reverse();
        return view('livewire.comments-lister');
    }

    public function booted()
    {
        $this->comments = Comment::all()->reverse();
    }

    public function refreshCommentsData()
    {
        $this->comments = Comment::all()->reverse();
    }
    
    public function newCommentAdd($product_id)
    {
        $this->booted();
    }

    public function loadProductImages($product_id)
    {
        $this->emit('loadProductImages', $product_id);
    }




}
