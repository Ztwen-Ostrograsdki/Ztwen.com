@if($products->count() > 0)
<div class="w-100 m-0 p-0 mt-3">
    <table class="w-100 m-0 p-0 table-striped z-table-border border z-table text-white mb-2">
        <thead class="text-white text-center">
            <th class="py-2 text-center border-right">#ID</th>
            <th class="">L'article</th>
            <th>Prix</th>
            <th>Posté dépuis</th>
            <th>Demandes</th>
            <th>Vendus</th>
            <th>Action</th>
        </thead>
        <tbody>
            @foreach($products as $key => $p)
                <tr class="">
                    <td class="text-center border-right">{{$key + 1}}</td>
                    <td class="p-0 m-0">
                        <a class="text-white w-75 p-0 m-0" href="{{route('product-profil', ['id' => $p->id])}}">
                            @if($p->images->count() > 0)
                                <img class="m-0 p-0 d-inline-block border ml-1 my-1" width="50" src="/storage/articlesImages/{{$p->getProductDefaultImageInGalery()}}" alt="image de l'article {{$p->slug}}">
                            @else
                                <img class="m-0 p-0 d-inline-block border ml-1 my-1" width="50" src="{{$p->getRandomDefaultImage()}}" alt="image de l'article {{$p->slug}}">
                            @endif
                            <span class="">
                                {{ mb_substr($p->getName(), 0, 14) }}
                            </span>
                        </a>
                        <span wire:click="editAProduct({{$p->id}})" class="mt-3 mr-1 cursor-pointer float-right fa fa-edit text-white" data-toggle="modal" data-dismiss="modal" data-target="#EditCategoryModal"></span>
                    </td>
                    <td class="p-0 mx-2 pl-2">
                        {{ $p->price }}
                    </td>
                    <td class="text-center">
                        {{ str_ireplace("Il y a ", '', $p->dateAgoToString) }}
                    </td>
                    <td class="">
                        <x-dropdown align="right" width="48" class="text-bold m-0 p-0 bg-secondary">
                            <x-slot name="trigger">
                                <x-responsive-nav-link class="text-white-50 cursor-pointer">
                                    <span class="fa fa-chevron-down text-success"></span> 
                                        Aucune demande
                                </x-responsive-nav-link>
                            </x-slot>
                            <x-slot name="content" :class="'text-left p-0 m-0'">
                                    <x-dropdown-link class="nav-item text-left w-100 p-0 m-0 z-hover-secondary text-bold" href="#">
                                        <span class="fa  mr-3"></span>Aucune demande pour cet article
                                    </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </td>
                    <td class="text-center">{{ '00' }}</td>
                    @if($p->deleted_at)
                    <td class="text-center w-auto p-0">
                        <span class="row mx-auto w-100 m-0 p-0">
                            <span title="Supprimer définivement cet article. Il sera ainsi rétiré définitivement des articles postés" wire:click="forceDeleteAProduct({{$p->id}})" class="text-danger  col-6 p-2 px-3 cursor-pointer fa fa-trash"></span>
                            <span title="Restaurer cet article, Il sera ainsi visible à nouveau dans les articles postés!" wire:click="restoreThisProduct({{$p->id}})" class="text-success border-left col-6 p-2 px-3 cursor-pointer fa bi-back"></span>
                        </span>
                    </td>
                    @else
                    <td class="text-center w-auto p-0">
                        <span class="row mx-auto w-100 m-0 p-0">
                            <span title="Supprimer définivement cet article. Il sera ainsi rétiré définitivement des articles postés" wire:click="forceDeleteAProduct({{$p->id}})" class="text-danger  col-4 p-2 px-3 cursor-pointer fa fa-trash"></span>
                            <span title="Envoyez cet article dans la corbeille. Il sera ainsi rétiré des articles postés" wire:click="deleteAProduct({{$p->id}})" class="text-info col-4 p-2 px-3 cursor-pointer fa fa-trash border-right border-left"></span>
                            <span title="Retirer cet article des postes pour le moment, masquer cet article!" wire:click="hideThisProduct({{$p->id}})" class="text-warning col-4 p-2 px-3 cursor-pointer fa fa-reply"></span>
                        </span>
                    </td>

                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>                                                     
</div>
@else
    <div class="d-flex flex-column mx-auto text-center p-3 mt-4">
        <span class="fa fa-warning text-warning fa-4x"></span>
        <h4 class="text-warning fa fa-3x">Ouups aucun article encore enregisté !!!</h4>
    </div>
@endif