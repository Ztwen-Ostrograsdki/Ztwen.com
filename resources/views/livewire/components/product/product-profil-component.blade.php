<div>
    <div class="mx-auto p-0 border shadow mb-2">
        <div class="row m-0 mx-auto p-0 w-100">
            <div class="col-12 p-0 m-0" style="height: auto !important">
                @if($product && $product->images->count() > 0 && $product->productGalery() !== [])
                <div id="productProfilImagesCarouselTrue" class="carousel slide m-0" data-ride="carousel">
                    <ol class="carousel-indicators">
                        @foreach ($product->productGalery() as $key => $image)
                            <li data-target="#productProfilImagesCarouselTrue" data-slide-to="{{$key}}" class="@if($key == 0)active @endif"></li>
                        @endforeach
                    </ol>
                    <div class="carousel-inner w-100 h-100">
                        @foreach ($product->productGalery() as $key => $image)
                            <div class="carousel-item @if($key == 0)active @endif">
                                <img class="" width="100%" class="" src="/storage/articlesImages/{{$image->name}}" alt="slide-{{$key}}">
                            </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#productProfilImagesCarouselTrue" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#productProfilImagesCarouselTrue" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
                @elseif($product->images->count() < 1 || $product->productGalery() == [])
                <div id="productProfilImagesCarouselFalse" class="carousel slide  m-0" data-ride="carousel">
                    <ol class="carousel-indicators">
                        @foreach ($product->productGalery() as $key => $image)
                            <li data-target="#productProfilImagesCarouselFalse" data-slide-to="{{$key}}" class="@if($key == 0)active @endif"></li>
                        @endforeach
                    </ol>
                    <div class="carousel-inner border w-100 h-100">
                        @foreach ($product->productGalery() as $key => $image)
                            <div class="carousel-item @if($key == 0)active @endif">
                                <img width="" class="" src="{{$image}}" alt="slide-{{$key}}">
                            </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#productProfilImagesCarouselFalse" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#productProfilImagesCarouselFalse" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
                @else
                <div id="productProfilImagesCarouselFalse" class="carousel slide m-0" data-ride="carousel">
                    <ol class="carousel-indicators">
                            <li data-target="#productProfilImagesCarouselFalse" data-slide-to="{{$key}}" class="@if($key == 0)active @endif"></li>
                    </ol>
                    <div class="carousel-inner w-100 h-100">
                        <div class="carousel-item @if($key == 0)active @endif">
                            <img width="150" class="" src="{{$image}}" alt="slide-{{$key}}">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#productProfilImagesCarouselFalse" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#productProfilImagesCarouselFalse" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
                @endif
            </div>
            <div class="col-12">
                <h6 class="text-center text-uppercase py-2">
                    Article : 
                    <strong>
                        {{$product->getName()}}
                    </strong>
                </h6>
                <hr>

                <div class="w-100 mx-auto d-flex flex-column">
                    <span class="d-flex justify-content-between">
                        <strong class="text-bold">Description :</strong>
                        <small class="text-secondary">Posté {{ $product->getDateAgoFormated(true) }}</small>
                    </span>
                    <span>
                        {{$product->description}}
                    </span>
                </div>
                <hr>

                <div class="d-flex w-100 justify-content-between">
                    <span>
                        <strong>Prix: </strong> <span>{{$product->price}} FCFA</span>
                    </span>
                    <span>
                        <strong>Total: </strong> <span>{{$product->total}}</span>
                    </span>
                    <span>
                        <strong>vendus: </strong> <span>{{$product->sells}}</span>
                    </span>
                    <span>
                        <strong>Reduction: </strong> <span>{{$product->reduction}}</span> <span>%</span>
                    </span>
                </div>
                <div class="d-flex justify-content-end w-100 text-danger">
                    <strong>
                        <strong class="mt-1"> {{$product->likes->count()}}</strong>
                        <strong class="fa fa-heart mt-1"></strong>
                    </strong>
                    <strong class="mx-3">
                        <strong class="mt-1"> {{$product->comments->count()}} </strong>
                        <strong class="fa fa-comments mt-1"></strong>
                    </strong>
                    <strong class="">
                        <strong class="mt-1"> {{$product->seen}} </strong>
                        <strong class="fa fa-eye mt-1"></strong>
                    </strong>
                </div>

                <div class="d-flex justify-content-between">
                    <div class="d-flex justify-content-end">
                        @isAdmin()
                        <span wire:click="editAProduct({{$product->id}})"  class="z-scale py-1 cursor-pointer btn-secondary mr-2 py-0 px-3 border border-white">
                            <span class="fa fa-edit p-0 m-0"></span> <small class="d-none d-lg-inline d-xlg-inline d-md-inline">Editer</small>
                        </span>
                        @endisAdmin
                        @auth
                            <span class="z-scale py-1 cursor-pointer btn-primary py-0 px-3 border border-white">
                                <span wire:click="bought({{$product->id}})" class="bi-download p-0 m-0"></span> <small class="d-none d-lg-inline d-xlg-inline d-md-inline">Acheter</small>
                            </span>
                            @if(Auth::user()->alreadyIntoCart($product->id))
                                <span wire:click="deleteFromCart({{$product->id}})" class="z-scale py-1 cursor-pointer btn-danger mx-2 px-3 border border-white">
                                    <span class="bi-minecart "></span> <small class="d-none d-lg-inline d-xlg-inline d-md-inline">Retirer du panier</small>
                                </span>
                            @else
                                <span wire:click="addToCart({{$product->id}})" class="z-scale py-1 cursor-pointer btn-primary mx-2 px-3 border border-white">
                                    <span class="bi-minecart "></span> <small class="d-none d-lg-inline d-xlg-inline d-md-inline">Panier</small>
                                </span>
                            @endif
                        @endauth
                        @guest
                        <span class="z-scale py-1 cursor-pointer bg-primary border border-dark py-0 px-3">
                            <span wire:click="bought({{$product->id}})" class="bi-download p-0 m-0"></span> <small class="d-none d-lg-inline d-xlg-inline d-md-inline">Acheter</small>
                        </span>
                        <span wire:click="addToCart({{$product->id}})" class="z-scale py-1 cursor-pointer bg-success mx-2 px-3 border">
                            <span class="bi-minecart "></span> <small class="d-none d-lg-inline d-xlg-inline d-md-inline">Panier</small>
                        </span>
                        @endguest
                        @isAdmin()
                        <span wire:click="updateProductGalery({{$product->id}})" class="z-scale cursor-pointer py-1 btn-primary px-3 border border-white">
                            <span class="bi-image"></span> <small class="d-none d-lg-inline d-xlg-inline d-md-inline">Ajouter une image</small>
                        </span>
                        @endisAdmin
                        @auth
                            <span wire:click="liked({{ $product->id }})" class="cursor-pointer mx-2 mt-1 z-scale" title="Liker cet article">
                                <span class="fa fa-2x fa-heart text-danger"></span>
                            </span>
                        @endauth
                    </div>
                </div>
                <div class="d-flex justify-content-center mx-auto w-auto mt-2">
                    <h6 class="text-center p-2 text-uppercase">
                        <span class="text-secondary">Catégorie:</span> 
                        <span class="text-white">
                            <a class="text-primary" href="{{route('category', ['id' => $product->category_id])}}">
                                {{ $product->category->name }}
                            </a>
                        </span>
                    </h6>
                </div>
                <div class="d-flex justify-content-end m-0 w-auto">
                    <small class="text-muted py-1">
                        Article édité {{ $product->getDateAgoFormated() }}
                    </small>
                </div>

            </div>
        </div>
    </div>
</div>