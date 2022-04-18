<div class="m-0 p-0 w-100">
    <div class="z-justify-relative-top-80 w-100" style="width: 90%;">
        <div class="w-100 border m-0 p-0">
            <div class="m-0 p-0 w-100 z-banner text-center" style="font-family: Haettenschweiler, 'Arial Narrow Bold', sans-serif; word-spacing: 5px; letter-spacing: 2px;">
                <h2 class="text-uppercase pt-3">nouvel arrivage</h2>
                <h1 class="text-capitalize">Les catégories à la une</h1>                           
            </div>
            <div class=" d-flex w-100 mx-auto justify-content-center mt-1">
                <div class="d-flex justify-content-between w-100" >
                    <div class="w-25 bg-secondary border border-primary" style="max-height: 400px; overflow: auto">
                        <h4 class="w-100 py-2 bg-secondary text-center text-white">Les catégories</h4>   
                        <div class="w-100 d-flex flex-column">
                            @foreach ($categories as $cat)
                                <h4 wire:click="changeCategory({{$cat->id}})" class="cursor-pointer z-hover-secondary py-2 border border-bottom px-2">
                                    <span>{{$cat->name}} </span> <span class="text-right float-right">({{$cat->products->count()}})</span>
                                </h4>
                            @endforeach
                        </div>
                        <span class="my-2"></span>
                    </div>
                    <div class="w-75 p-2" style="max-height: 400px; overflow: auto">
                        @if($category)
                            <div class="z-secondary w-100">
                                <h4 class="d-flex justify-content-between cursor-pointer text-center text-white py-2 border border-bottom px-2">
                                    <span class="text-center pt-2">
                                        <span>{{$category->name}} </span> <span class="">({{$category->products->count()}})</span>
                                    </span>
                                   @if($category->products->count() > 0)
                                        @isAdmin()
                                        <span wire:click="createNewCategory" data-target="#createProductModal" data-toggle="modal" data-dismiss="modal" class="btn btn-primary border border-white">
                                            <span class="fa fa-plus"></span>
                                            Ajouter un article
                                        </span>
                                        @endisAdmin
                                   @else
                                        <span class="btn btn-info border border-warning">
                                            Aucun article enregistré
                                        </span>
                                   @endif
                                </h4>
                               
                            </div>

                            @if($category->products->count() > 0)
                                <div class="w-100 mx-auto my-1">
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
                                                            <small class="text-secondary">Posté {{ $p->dateAgoToString }}</small>
                                                        </span>
                                                        <span>
                                                            {{$p->description}}
                                                        </span>
                                                    </div>
                                                    <hr>

                                                    <div class="d-flex w-100 justify-content-between">
                                                        <span>
                                                            <strong>Prix: </strong> <span>{{$p->price}}</span>
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
                                                            Editée le {{ $p->dateAgoToStringForUpdated }}
                                                        </small>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="w-100 mx-auto my-1 bg-info border d-flex flex-column justify-content-center">
                                    <h3 class="text-warning p-2 text-center">
                                        <span class="fa fa-warning mr-2"></span>
                                        Oooups!!! Cette catégorie n'a pas encore d'articles enregistrés!
                                    </h3>
                                    @isAdmin()
                                        <div class="mx-auto my-2 w-100 d-flex justify-content-center">
                                            <span wire:click="createNewCategory" data-target="#createProductModal" data-toggle="modal" data-dismiss="modal" class="btn btn-primary border border-white">
                                                <span class="fa fa-plus"></span>
                                                Ajouter un article
                                            </span>
                                        </div>
                                    @endisAdmin
                                </div>
                            @endif
                        @else
                            <h4 class="cursor-pointer z-secondary text-center text-white py-2 border border-bottom px-2">
                                <span> Selectionnez une catégorie </span>
                            </h4>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>