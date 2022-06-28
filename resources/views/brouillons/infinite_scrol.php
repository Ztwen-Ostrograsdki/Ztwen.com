<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;

class LoadProducts extends Component
{
    public $perPage;
    public $page;

    public function mount($page = null, $perPage = null) 
    {
        $this->page = $page ?? 1;
        $this->perPage = $perPage ?? 10;
    }
}


 public function render()
    {
        $products = Product::paginate($this->perPage, ['*'], null, $this->page);
        return view('livewire.products.load-products', [
            'products' => $products
        ]);
    }




    // Blade


    <div>
    @foreach($productsas $result)
       .
       . 
       .
    @endforeach
</div>
<x-button wire:click="loadMore">Load More Products</x-button>

@if($products->hasMorePages())
        @livewire('load-more-products', ['page' => $page, 'perPage' => $perPage, 'key' => 'products-page-' . $page])
    @endif





    // LORD MORE COMPO


namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;

class LoadMoreProducts extends Component
{

    public $perPage;
    public $page;
    public $loadMore = false;

    public function mount($page = null, $perPage = null) 
    {
        $this->page = $page ?? 1;
        $this->perPage = $perPage ?? 10;
    }

    public function loadMore() 
    {
        $this->page += 1;
        $this->loadMore = true;
    }

    public function render()
    {
        if (!$this->loadMore) {
            return view('livewire.products.load-more-products');
        } else {
            $products = Product::paginate($this->perPage, ['*'], null, $this->page);

            return view('livewire.products.load-products', [
                'products' => $products
            ]);
        }
    }
}

view.blade
<x-button wire:click="loadMore">Load More Products</x-button>

<div x-data="{
    checkScroll() {
            window.onscroll = function(ev) {
                if ((window.innerHeight + window.scrollY) >= document.body.scrollHeight) {
                     @this.call('loadMore')
                }
            };
        }
    }"

    x-init="checkScroll">