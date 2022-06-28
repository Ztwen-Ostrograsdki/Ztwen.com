<div>
    <div class="page-heading products-heading header-text">
        <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="text-content">
                    <h4>nouvel arrivage</h4>
                    <h2>Les articles à la une</h2> 
                </div>
                {{-- search --}}
                <div class="input-group my-3 w-75 mx-auto">
                    <input type="text" wire:model.debounce.500ms="target" class="form-control bg-transparent border border-white text-white" placeholder="Taper un mot ou groupe de mots clé" aria-label="Chercher" aria-describedby="basic-addon2">
                    <div class="input-group-append cursor-pointer bg-primary">
                        <span class="input-group-text bg-primary text-white" id="basic-addon2">
                            <span class="fa fa-search mx-2"></span>
                            <span>Rechercher</span>
                        </span>
                    </div>
                </div>
                @if ($target !== null && strlen($target))
                    <div class="text-white mx-auto">
                        <div>
                            <h4>
                                <span> {{$products_records}} </span> résultats trouvés pour "<span class='text-warning'>{{$target}}</span>"
                            </h4>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        </div>
    </div>
    @if($products_records > 0)
        <div class="products">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div class="mx-auto w-100 d-flex justify-content-center">
                            <select wire:change="changeCategory" wire:model="categorySelected" class="bg-info form-select-lg text-white py-2" name="categories" id="categories">
                                <option class="text-dark" value="">Selectionner la catégorie à afficher</option>
                                @foreach ($categories as $category)
                                    <option value="{{$category->id}}">
                                        {{$category->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="filters">
                            <ul>
                                @if ($categorySelected)
                                    <li class="@if(session()->has('sectionSelected') && session('sectionSelected') == 'allPosted') active @endif" data-filter="*"> 
                                        <span class="text-dark">Catégorie listée</span> : {{$categorySelected}} 
                                        @if(count($products_targeted) > 9)
                                            <span>({{count($products_targeted)}})</span>
                                        @else
                                            <span>(0{{count($products_targeted)}})</span>
                                        @endif
                                    </li> 
                                @else
                                    <li wire:click="changeSection('allPosted')" class="@if(session()->has('sectionSelected') && session('sectionSelected') == 'allPosted') active @endif" data-filter="*">Tous les articles 
                                        @if(count($products_targeted) > 9)
                                            <span>({{count($products_targeted)}})</span>
                                        @else
                                            <span>(0{{count($products_targeted)}})</span>
                                        @endif
                                    </li>
                                @endif
                                <li class="@if(session()->has('sectionSelected') && session('sectionSelected') == 'lastPosted') active @endif" wire:click="changeSection('lastPosted')" data-filter=".des">Les plus récents</li>
                                <li class="@if(session()->has('sectionSelected') && session('sectionSelected') == 'mostSeen') active @endif" wire:click="changeSection('mostSeen')" data-filter=".gras">Les plus visités</li>
                                <li data-filter=".dev">Flash trocs</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(!$searching)
            <div>
                @livewire('show-products')
            </div>
        @else
        <div>
            @livewire('show-products', ['scroll' => false, 'targets' => $target])
        </div>
        @endif
    @elseif(auth()->user() && auth()->user()->role == "master")
        <h3 class="z-color-orange z-bg-secondary p-2 py-3 mt-2 text-center w-75 mx-auto border">Veuillez ajouter des articles...</h3>
    @endif
</div>