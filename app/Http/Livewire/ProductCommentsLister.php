<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;

class ProductCommentsLister extends Component
{
    public $product;
    public $comments;
    protected $listeners = ['newCommentAdd', 'aCommentWasApproved'];

    public function mount()
    {
        $id = (int)request()->id;
        if($id){
            $product = Product::find($id);
            if($product){
                $this->product = $product;
            }
        }
        $this->comments = $this->product->comments->where('approved', true)->where('blocked', false)->reverse()->take(10);
    }


    public function render()
    {
        return view('livewire.product-comments-lister');
    }

    public function updateCommentsData()
    {
        $this->comments = $this->product->comments->where('approved', true)->where('blocked', false)->reverse()->take(10);
    }

    public function updatedComments()
    {
        $this->comments = $this->product->comments->where('approved', true)->where('blocked', false)->reverse()->take(10);
    }


    public function aCommentWasApproved()
    {
        return $this->updateCommentsData();
    }

    public function newCommentAdd($product_id = null)
    {
        return $this->mount();
    }
}
