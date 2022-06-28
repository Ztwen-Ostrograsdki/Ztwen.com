<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use App\Models\Category;

class LoadMoreProducts extends Component
{

    public $perPage;
    public $page;
    public $loadMore = false;
    public $alreadyLoaded = false;
    public $active_section;
    public $records = 6;
    public $categorySelected = null;
    public $target = null;

    protected $listeners = [
        
    ];


    public function mount($page = null, $perPage = null) 
    {
        $this->page = $page ?? 1;
        $this->perPage = $perPage ?? 6;
    }

    public function loadMore() 
    {
        $this->page += 1;
        $this->loadMore = true;
        $this->alreadyLoaded = true;
    }

    public function backToLessData() 
    {
        $this->page = 1;
        $this->loadMore = true;
        $this->alreadyLoaded = false;
    }

    public function render()
    {
        
        if (!$this->loadMore) {
            return view('livewire.load-more-products');
        } else {
            $products = Product::paginate($this->perPage, ['*'], null, $this->page);

            return view('livewire.show-products', [
                'products' => $products,
            ]);
        }
    }
}
