<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class ProductsHome extends Component
{
    protected $listeners = [
        
    ];
    public $active_section;
    public $products_targeted = [];
    public $records = 6;
    public $categorySelected = null;
    public $target = null;
    public $searching = false;
    public $changer = false;
    public $perPage;
    public $page;

    public function mount($page = null, $perPage = null) 
    {
        $this->page = $page ?? 1;
        $this->perPage = $perPage ?? 6;

        if(session()->has('sectionSelected') && session('sectionSelected')){
            $this->active_section = session('sectionSelected');
        }
        else{
            $this->active_section = 'allPosted';
        }
        if(session()->has('categorySelected') && session('categorySelected')){
            $this->categorySelected = session('categorySelected');
        }
    }

    public function render()
    {
        $categories = Category::all();
        $products_records = Product::all()->count();
        $categories = Category::all();
        $cat = null;
        if($this->categorySelected){
            $cat = Category::find((int)$this->categorySelected);
        }

        return view('livewire.products-home', [
            'categories' => $categories,
            'products_records' => $products_records,
            'categoryName' => $cat,
        ]);
    }

    public function updatedTarget($value)
    {
        if($value && mb_strlen($value) > 3){
            $this->searching = true;
        }
        else{
            $this->reset('searching');
        }
    }

    public function productUpdated($product_id)
    {
        $this->getProducts($this->active_section); 
    }


    public function changeCategory()
    {
        session()->put('categorySelected', (int)$this->categorySelected);
        $this->emit('refreshData', $this->active_section, $this->categorySelected);
    }

    public function changeSection(string $section)
    {
        $this->active_section = $section;
        session()->put('sectionSelected', $this->active_section);
        $this->emit('refreshData', $this->active_section, $this->categorySelected);
    }

    

}
