<div>
    @if($cart && $product)
    <div wire:ignore.self class="modal fade lug" id="userCartManagerModal" role="dialog" >
        <div class="modal-dialog modal-z-xlg" role="document">
            <div class="modal-content z-bg-secondary border" style="position: absolute; top:100px; z-index: 2010">
                <div class="modal-header">
                    <div class="d-flex justify-content-between w-100">
                        <h6 class="text-uppercase mr-2 mt-1 text-white-50">
                            Gestion du panier de <span class="bi-person"></span> {{$user->name}}
                            @if (session()->has('alert'))
                                <span class="alert text-capitalize alert-{{session('type')}} ml-4">{{session('alert')}}</span>
                            @endif
                        </h6>
                        <div class="d-flex justify-content-end w-20">
                        <button type="button" class="close text-danger" data-dismiss="modal">&times;</button>
                        </div>
                    </div>
                </div>
                <div class="modal-body m-0 p-0 z-bg-secondary">
                    <div class="">
                        <div class="">
                            <div class="z-bg-secondary row w-100 p-0 m-0">
                                <div class=" p-0 col-12">
                                    <h6 class="z-title text-white-50 text-center p-1 m-0 "> Gestion de du panier concernant l'article : 
                                        <br>
                                        <span class="bi-tags mx-1"></span>
                                        <span class="text-capitalize">
                                        {{ $product ? $product->getName() : "" }} de la catégorie {{$product->category->name}}
                                        </span>
                                        <span class="bi-tags mx-1"></span>
                                    </h6>
                                    <div class="row w-100 mx-auto">
                                        <div class="mx-auto col-8">
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
                                        </div>
                                        <div class="text-white-50 col-8 px-1 pl-2 mx-auto my-1">
                                            <h6>
                                                <strong>Prix unitaire (PU) : </strong>
                                                <span>{{$product->price}} FCFA</span>
                                            </h6>
                                            <h6>
                                                <strong>Quantityé (Qt) : </strong>
                                                <span>{{$cart->quantity}}</span>
                                            </h6>
                                            <h6>
                                                <strong>Montant (Mt) : </strong>
                                                <span>{{$cart->quantity * $product->price}} FCFA</span>
                                            </h6>
                                        </div>

                                        <div class="col-8 px-1 text-dark mx-auto my-1 d-flex justify-content-around">
                                            <span class="btn bg-success">
                                                <small class="bi-check-all"></small>
                                                <small class="d-none d-xxl-inline d-xl-inline d-lg-inline mx-1">Approuver</small>
                                            </span>
                                            <span class="btn bg-warning">
                                                <small class="bi-question"></small>
                                                <small class="d-none d-xxl-inline d-xl-inline d-lg-inline mx-1">Indesirable</small>
                                            </span>
                                            <span class="btn bg-orange">
                                                <small class="bi-trash"></small>
                                                <small class="d-none d-xxl-inline d-xl-inline d-lg-inline mx-1">Supprimer</small>
                                            </span>
                                            <span class="btn bg-primary">
                                                <small class="bi-messenger"></small>
                                                <small class="d-none d-xxl-inline d-xl-inline d-lg-inline mx-1">Message</small>
                                            </span>
                                        </div>
                                        <div class="text-warning col-12 px-1 mx-auto d-flex justify-content-end">
                                            <small>
                                                <small class="bi-clock"></small>
                                                <small>Demande effectuée</small>
                                                <small>{{$cart->getDateAgoFormated(true) }}</small>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>