<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class ShowCategories extends Component
{
    protected $listeners = [
       
    ];
    public $search;
    public $targets;
    public $galery;
    public $categorySelectedID;
    public $page;
    public $perPage;

    public function mount($page = null, $perPage = null) 
    {
        $this->page = $page ?? 1;
        $this->perPage = $perPage ?? 8;
    }


    public function render()
    {
        if($this->search && strlen($this->search) > 2){
            $categories = Category::orderBy('name', 'asc')
                                    ->where('name', 'like', '%' . $this->search . '%')
                                    ->orWhere('description', 'like', '%' . $this->search . '%')
                                    ->paginate($this->perPage, ['*'], null, $this->page);

        }
        else{
            $categories = Category::orderBy('name', 'asc')->paginate($this->perPage, ['*'], null, $this->page);
        }
        $user = Auth::user();
        return view('livewire.show-categories', compact('categories'));
    }

    public function loadMoreCategories($lastPage)
    {
        $this->page !== $lastPage ? $this->page += 1 : $this->page = 1;
    }

    public function loadLessCategories($lastPage)
    {
        $this->page !== 1 ? $this->page -= 1 : $this->page = $lastPage;
    }


    public function editACategory($category_id)
    {
        $category = Category::withTrashed('deleted_at')->whereId($category_id)->firstOrFail();
        if($category){
            $this->emit('targetedCategory', $category->id);
        }
    }


    public function updatedSearch($v)
    {
        $this->search = $v;
    }

    public function updategalery($product_id)
    {
        $product = Product::find($product_id);
        if($product){
            $this->emit('targetedProduct', $product->id);
            $this->dispatchBrowserEvent('modal-updateProductGalery');
        }
    }

    
    
}
