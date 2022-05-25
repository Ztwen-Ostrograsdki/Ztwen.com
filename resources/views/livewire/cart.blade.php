<div>
    <div class="col-md-12">
        <div class="filters-content">
            <div class="row grid">
                @foreach ($products as $p)
                <div class="w-100 mx-auto p-0 border shadow mb-2">
                    <div class="row m-0 mx-auto p-0 w-100">
                        <div class="col-3 p-0 m-0">
                            @if($p->images->count() > 0)
                                <img width="" class="w-100" src="/storage/articlesImages/{{$p->getProductDefaultImageInGalery()}}" alt="image de l'article {{$p->slug}}">
                            @else
                                <img width="150" class="w-100" src="{{$p->getRandomDefaultImage()}}" alt="image de l'article {{$p->slug}}">
                            @endif
                        </div>
                        <div class="col-9">
                            <h4 class="text-center text-uppercase py-1">
                                <strong>
                                    {{$p->getName()}}
                                </strong>
                            </h4>
                            <hr>

                            <div class="w-100 mx-auto d-flex flex-column">
                                <span class="d-flex justify-content-between">
                                    <strong class="text-bold">Description :</strong>
                                    <small class="text-secondary">Posté {{ $p->getDateAgoFormated(true) }}</small>
                                </span>
                                <span>
                                    {{$p->description}}
                                </span>
                            </div>
                            <hr>

                            <div class="d-flex w-100 justify-content-between">
                                <span>
                                    <strong>Prix: </strong> <span>{{$p->price}} FCFA</span>
                                </span>
                                <span>
                                    <strong>Total: </strong> <span>{{$p->total}}</span>
                                </span>
                                <span>
                                    <strong>vendus: </strong> <span>{{$p->sells}}</span>
                                </span>
                                <span>
                                    <strong>Reduction: </strong> <span>{{$p->reduction}}</span> <span>%</span>
                                </span>
                            </div>
                            <div class="d-flex justify-content-end w-100 text-danger">
                                <strong>
                                    <strong class="mt-1"> {{$p->likes->count()}}</strong>
                                    <strong class="fa fa-heart mt-1"></strong>
                                </strong>
                                <strong class="mx-3">
                                    <strong class="mt-1"> {{$p->comments->count()}} </strong>
                                    <strong class="fa fa-comments mt-1"></strong>
                                </strong>
                                <strong class="">
                                    <strong class="mt-1"> {{$p->seen}} </strong>
                                    <strong class="fa fa-eye mt-1"></strong>
                                </strong>
                            </div>

                            <div class="d-flex justify-content-between">
                                <div class="d-flex justify-content-end">
                                    @isAdmin()
                                    <span wire:click="editAProduct({{$p->id}})"  class="z-scale py-1 cursor-pointer btn-secondary mr-2 py-0 px-3 border border-white">
                                        <span class="fa fa-edit p-0 m-0"></span> <small class="d-none d-lg-inline d-xlg-inline d-md-inline">Editer</small>
                                    </span>
                                    @endisAdmin
                                    @auth
                                        <span class="z-scale py-1 cursor-pointer btn-primary py-0 px-3 border border-white">
                                            <span wire:click="bought({{$p->id}})" class="bi-download p-0 m-0"></span> <small class="d-none d-lg-inline d-xlg-inline d-md-inline">Acheter</small>
                                        </span>
                                        @if(Auth::user()->alreadyIntoCart($p->id))
                                            <span wire:click="deleteFromCart({{$p->id}})" class="z-scale py-1 cursor-pointer btn-danger mx-2 px-3 border border-white">
                                                <span class="bi-minecart "></span> <small class="d-none d-lg-inline d-xlg-inline d-md-inline">Retirer du panier</small>
                                            </span>
                                        @else
                                            <span wire:click="addToCart({{$p->id}})" class="z-scale py-1 cursor-pointer btn-primary mx-2 px-3 border border-white">
                                                <span class="bi-minecart "></span> <small class="d-none d-lg-inline d-xlg-inline d-md-inline">Panier</small>
                                            </span>
                                        @endif
                                    @endauth
                                    @guest
                                    <span class="z-scale py-1 cursor-pointer btn-primary py-0 px-3 border border-white">
                                        <span wire:click="bought({{$p->id}})" class="bi-download p-0 m-0"></span> <small class="d-none d-lg-inline d-xlg-inline d-md-inline">Acheter</small>
                                    </span>
                                    <span wire:click="addToCart({{$p->id}})" class="z-scale py-1 cursor-pointer btn-primary mx-2 px-3 border border-white">
                                        <span class="bi-minecart "></span> <small class="d-none d-lg-inline d-xlg-inline d-md-inline">Panier</small>
                                    </span>
                                    @endguest
                                    @isAdmin()
                                    <span wire:click="updategalery({{$p->id}})" class="z-scale cursor-pointer py-1 btn-primary px-3 border border-white">
                                        <span class="bi-image"></span> <small class="d-none d-lg-inline d-xlg-inline d-md-inline">Ajouter une image</small>
                                    </span>
                                    @endisAdmin
                                    @auth
                                        <span wire:click="liked({{ $p->id }})" class="cursor-pointer mx-2 mt-1 z-scale" title="Liker cet article">
                                            <span class="fa fa-2x fa-heart text-danger"></span>
                                        </span>
                                    @endauth
                                </div>
                                <small class="text-muted mt-2">
                                    Editée le {{ $p->getDateAgoFormated() }}
                                </small>
                            </div>


                        </div>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    </div>
</div>
