@if($categories->count() > 0)
<div class="w-100 m-0 p-0 mt-3">
    <table class="w-100 m-0 p-0 table-striped table-bordered z-table text-white mb-2">
        <thead class="text-white text-center">
            <th class="py-2 text-center">#ID</th>
            <th class="">Catégorie</th>
            <th>Description</th>
            <th>Articles</th>
            <th>Vendus</th>
            <th>Action</th>
        </thead>
        <tbody>
            @foreach($categories as $key => $c)
                <tr class="z-hover-secondary">
                    <td class="py-2">{{$key + 1}}</td>
                    <td class="p-0">
                        <a class="text-white col-9 h-100 d-inline-block py-2 pl-1" href="{{route('category', ['id' => $c->id])}}">
                            {{$c->name}}
                        </a>
                        <span class="col-3 py-2 cursor-pointer float-right fa fa-edit text-white" data-toggle="modal" data-dismiss="modal" data-target="#EditCategoryModal"></span>

                    </td>
                    <td class="p-0">
                        <a class="text-white w-100 h-100 d-inline-block py-2 pl-1" href="{{route('category', ['id' => $c->id])}}">
                            {{ mb_substr($c->description, 0, 27) }} ...
                        </a>
                    </td>
                    <td class="">
                        <x-dropdown align="right" width="48" class="text-bold m-0 p-0 bg-secondary">
                            <x-slot name="trigger">
                                <x-responsive-nav-link class="text-white-50 cursor-pointer">
                                    <span class="fa fa-chevron-down text-success"></span> 
                                    @if ($c->products->count() > 0)
                                        @if ($c->products->count() == 1)
                                            0{{ $c->products->count() }} article
                                        @elseif ($c->products->count() < 10)
                                            0{{ $c->products->count() }} articles
                                        @else
                                            {{ $c->products->count() }} articles
                                        @endif
                                    @else
                                    Aucun article posté
                                    @endif
                                </x-responsive-nav-link>
                            </x-slot>
                            <x-slot name="content" :class="'text-left p-0 m-0'">
                                @if ($c->products->count() > 0)
                                    @foreach ($c->products as $p)
                                        <x-dropdown-link class="nav-item text-left z-a w-100 p-0 m-0 z-hover-secondary text-bold"  href="{{route('product-profil', ['id' => $p->id])}}">
                                            {{ mb_substr($p->getName(), 0, 14) }}
                                        </x-dropdown-link>
                                    @endforeach
                                @else
                                    <x-dropdown-link class="nav-item text-left w-100 p-0 m-0 z-hover-secondary text-bold" href="#">
                                        <span class="fa  mr-3"></span>Aucun article
                                    </x-dropdown-link>
                                @endif
                            </x-slot>
                        </x-dropdown>
                    </td>
                    <td class="text-center">{{ $c->products->count() }}</td>
                    <td class="text-center w-auto p-0">
                        <span class="row mx-auto w-100 m-0 p-0">
                            <span class="text-danger  col-4 p-2 px-3 cursor-pointer fa fa-trash"></span>
                            <span class="text-info col-4 p-2 px-3 cursor-pointer fa fa-trash border-right border-left"></span>
                            <span class="text-warning col-4 p-2 px-3 cursor-pointer fa fa-key"></span>
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>                                                     
</div>
@else
    <div class="d-flex flex-column mx-auto text-center p-3 mt-4">
        <span class="fa fa-warning text-warning fa-4x"></span>
        <h4 class="text-warning fa fa-3x">Ouups aucune données enregistées !!!</h4>
    </div>
@endif